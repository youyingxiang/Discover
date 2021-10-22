<?php

/*
 * // +----------------------------------------------------------------------
 * // | erp
 * // +----------------------------------------------------------------------
 * // | Copyright (c) 2006~2020 erp All rights reserved.
 * // +----------------------------------------------------------------------
 * // | Licensed ( LICENSE-1.0.0 )
 * // +----------------------------------------------------------------------
 * // | Author: yxx <1365831278@qq.com>
 * // +----------------------------------------------------------------------
 */

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\AddApplyForOrder;
use App\Admin\Actions\Grid\AddMakeProduct;
use App\Admin\Extensions\Grid\ApplyOfOrders;
use App\Admin\Repositories\Task;
use App\Models\CraftModel;
use App\Models\ProductModel;
use App\Models\SkuStockBatchModel;
use App\Models\TaskModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Models\Administrator;
use Yxx\LaravelQuick\Exceptions\Api\ApiUnAuthException;

class TaskController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Task(['sku', 'user', 'sku.product', 'craft', 'operator_user']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('order_no');
            $grid->column('info', '产品信息')->display(function () {
                return $this->sku['product']['name']."|".$this->sku['attr_value_ids_str']."|".$this->percent."%|".$this->standard_str;
            });
            $grid->column('sum_cost_price', "领料总成本");
//            $grid->column('craft.name', '生产工艺');
            $grid->column('plan_num');
            $grid->column('finish_num');
            $grid->column('status_str', '状态')->label(TaskModel::STATUS_COLOR);
//            $grid->column('other')->emp();
//            $grid->column('user.name', "任务创建人");
            $grid->column('operator_user.name', "生产人员");
            $grid->column("_id", "领料记录")->expand(ApplyOfOrders::make());
            $grid->column('created_at');
            $grid->disableRowSelector();
            $grid->actions(function (\Dcat\Admin\Grid\Displayers\Actions $actions) {
                if ($this->status !== TaskModel::STATUS_FINISH) {
                    $actions->append("</br>");
                    $actions->append(new AddApplyForOrder());
                    $actions->append("</br>");
                } else {
                    $actions->disableQuickEdit();
                }
                $actions->append(new AddMakeProduct());
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('order_no')->width(3);
                $filter->equal('status', '状态')->select(TaskModel::STATUS)->width(3);
                $filter->group('plan_num', function ($group) {
                    $group->gt('大于');
                    $group->lt('小于');
                    $group->nlt('不小于');
                    $group->ngt('不大于');
                    $group->equal('等于');
                })->width(3);
                $filter->group('finish_num', function ($group) {
                    $group->gt('大于');
                    $group->lt('小于');
                    $group->nlt('不小于');
                    $group->ngt('不大于');
                    $group->equal('等于');
                })->width(3);
            });
            $grid->disableRowSelector();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Task(), function (Form $form) {
            $form->row(function (Form\Row $row) {
                $row->width(12)->html('<h1 align="center">生产任务单</h1>');
            });
            $form->row(function (Form\Row $row) {
                $row->width(4)->text('order_no', '订单号')->default(build_order_no('SCRW'))->readOnly();
                $row->width(4)->select('product_id', '名称')->options(ProductModel::pluck('name', 'id'))->loadpku(route('api.product.find'))->required();
                $row->width(4)->ipt('unit', '单位')->rem(3)->default('-')->disable();
            });
            $form->row(function (Form\Row $row) {
                $row->width(4)->select('sku_id', '属性选择')->options()->required();
                $row->width(4)->select('standard', '检验标准')->options(SkuStockBatchModel::STANDARD)->required();
                $row->width(4)->rate('percent', '含绒百分比')->default(0)->required();
            });

            $form->row(function (Form\Row $row) {
                $craft = CraftModel::query()->latest()->pluck('name', 'id');
                $row->width(4)->select('craft_id')->options($craft)->default(head($craft->keys()->toArray()))->required();
                $row->width(4)->decimal('plan_num')->default(0)->required();
                $row->width(4)->decimal('finish_num')->default(0)->required();
            });
            $form->row(function (Form\Row $row) {
                $users = Administrator::query()->latest()->pluck('name', 'id');
                $row->width(4)->select('operator')->options($users)->default(head($users->keys()->toArray()))->required();
                $row->width(4)->text('other')->saveAsString();
            });
        });
    }

    public function update($id)
    {
        $task = TaskModel::query()->findOrFail($id);
        if ($task->status > TaskModel::STATUS_DRAW) {
            throw new ApiUnAuthException("任务" .TaskModel::STATUS[$task->status]. "无法进行编辑");
        }
        return $this->form()->update($id);
    }
}
