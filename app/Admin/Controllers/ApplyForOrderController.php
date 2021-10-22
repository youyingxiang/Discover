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

use App\Admin\Actions\Grid\BatchOrderPrint;
use App\Admin\Actions\Grid\EditOrder;
use App\Admin\Extensions\Form\Order\OrderController;
use App\Admin\Extensions\Grid\BatchDeail;
use App\Admin\Repositories\ApplyForOrder;
use App\Models\ApplyForOrderModel;
use App\Models\ProductModel;
use App\Models\PurchaseOrderModel;
use App\Models\TaskModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Fluent;

class ApplyForOrderController extends OrderController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ApplyForOrder(['with_order', 'user']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('with_order.order_no', '任务单号')->emp();
            $grid->column('order_no');
            $grid->column('user.username', '创建用户');
            $grid->column('other')->emp();
            $grid->column('review_status', '审核状态')->using($this->oredr_model::REVIEW_STATUS)->label($this->oredr_model::REVIEW_STATUS_COLOR);
            $grid->column('created_at');
            $grid->disableQuickEditButton();
            $grid->tools(BatchOrderPrint::make());
            $grid->actions(EditOrder::make());

            $grid->filter(function (Grid\Filter $filter) {
                $filter->where('with_order_order_no', function (Builder $builder) {
                    $builder->whereHasIn('with_order', function (Builder $builder) {
                        $builder->where("order_no", "like", $this->getValue() . "%");
                    });
                }, '任务单号')->width(3);
                $filter->like('order_no')->width(3);
                $filter->equal('review_status', '审核状态')->select($this->oredr_model::REVIEW_STATUS)->width(3);
            });
        });
    }

    /**
     * @param Form $form
     */
    protected function setForm(Form &$form): void
    {
        $form->row(function (Form\Row $row) {
            $row->width(6)->text('order_no', '单号')->default(build_order_no('SL'))->required()->readOnly();
            $row->width(6)->text('created_at', '业务日期')->default(now())->required()->readOnly();
        });
        $with_order = $this->order_repository->getWithOrder();
        $form->row(function (Form\Row $row) use ($with_order,$form) {
            $order = $this->order;
            $review_statu_ok = $this->oredr_model::REVIEW_STATUS_OK;
            if ($order && $order->review_status === $review_statu_ok) {
                $row->width(6)->select('with_id', '相关单据')->options(TaskModel::query()->pluck('order_no', 'id'))->disable();
            } else {
                if ($form->isCreating() && request()->get('with_id')) {
                    $row->width(6)->select('', '相关单据')->options($with_order)->default(request()->get('with_id'))->disable();
                    $row->width(0)->hidden('with_id')->value(request()->get('with_id'));
                } else {
                    $row->width(6)->select('with_id', '相关单据')->options($with_order)->default(0)->required();
                }
            }
            $users = Administrator::query()->latest()->pluck('name', 'id');
            $row->width(6)->select('apply_id', '审批人')->options($users)->default(head($users->keys()->toArray()))->required();
        });
        $form->row(function (Form\Row $row) {
            $row->width(6)->text('other', '备注')->saveAsString();
        });
    }

    public function creating(Form &$form): void
    {
        $form->width(12)->row(function (Form\Row $row) {
            $row->hasMany('items', '', function (Form\NestedForm $table) {
                $table->select('product_id', '名称')->options(ProductModel::pluck('name', 'id'))->loadpku(route('api.product.find'))->required();
                $table->ipt('unit', '单位')->rem(3)->default('-')->disable();
                $table->select('sku_id', '属性选择')->options()->required();
                $table->tableDecimal('percent', '含绒百分比')->default(0);
                $table->select('standard', '检验标准')->options(PurchaseOrderModel::STANDARD)->default(0);
                $table->num('should_num', '申领数量')->required();
            })->useTable()->width(12)->enableHorizontal();
        });
    }

    public function setItems(Grid &$grid): void
    {
        $order = $this->order;
        $grid->column('sku.product.name', '产品名称');
        $grid->column('sku.product.unit.name', '单位');
        $grid->column('sku.product.type_str', '类型');
        $grid->column('sku_id', '属性')->if(function () use ($order) {
            return $order->review_status === ApplyForOrderModel::REVIEW_STATUS_OK;
        })->display(function () {
            return $this->sku['attr_value_ids_str'] ?? '';
        })->else()->selectplus(function (Fluent $fluent) {
            return $fluent->sku['product']['sku_key_value'];
        });

        $grid->column('percent', '含绒百分比')->if(function () use ($order) {
            return $order->review_status !== ApplyForOrderModel::REVIEW_STATUS_OK;
        })->edit();
        $grid->column('standard', '检验标准')->if(function () use ($order) {
            return $order->review_status === ApplyForOrderModel::REVIEW_STATUS_OK;
        })->display(function () {
            return ApplyForOrderModel::STANDARD[$this->standard];
        })->else()->selectplus(ApplyForOrderModel::STANDARD);
        $grid->column('cost_price', "成本总价");
        $grid->column('should_num', '申领数量');
        $grid->column('actual_num', '实领数量');
        $grid->column('sku_stock_num', "库存参考数量")->display(function ($val) {
            return $val;
        });
        $grid->column('pcxq', '批次详情')->batch_detail(function (BatchDeail $batchDeail) {
            return route('apply-for-batchs.index', [
                Grid::IFRAME_QUERY_NAME => 1,
                'item_id'               => $batchDeail->row->id,
                'sku_id'                => $batchDeail->row->sku_id,
                'standard'              => $batchDeail->row->standard,
                'percent'               => $batchDeail->row->percent,
            ]);
        });
    }
}
