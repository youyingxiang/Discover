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
use App\Admin\Actions\Grid\BatchStockSelect;
use App\Admin\Actions\Grid\EditOrder;
use App\Admin\Actions\Grid\OrderDelete;
use App\Admin\Actions\Grid\OrderPrint;
use App\Admin\Actions\Grid\OrderReview;
use App\Admin\Extensions\Form\Order\OrderController;
use App\Admin\Repositories\InventoryOrder;
use App\Models\InventoryModel;
use App\Models\InventoryOrderModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Builder;

class InventoryOrderController extends OrderController
{
    public $item_relations = ['stock_batch', 'stock_batch.sku', 'stock_batch.sku.product'];
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new InventoryOrder(['with_order', 'user']), function (Grid $grid) {
            $grid->model()->whereHas('with_order', function (Builder $builder) {
                $builder->where('status', "!=", InventoryModel::STATUS_NOT_STARTED);
            })->orderBy('id', 'desc');
            $grid->column('id')->sortable();
            $grid->column('order_no');
            $grid->column('with_order.order_no', '任务单号')->emp();
            $grid->column('user.username', '创建用户');
            $grid->column('review_status', '审核状态')->using($this->oredr_model::REVIEW_STATUS)->label($this->oredr_model::REVIEW_STATUS_COLOR);
            $grid->column('created_at');
            $grid->disableQuickEditButton();
            $grid->actions(EditOrder::make());

            $grid->disableCreateButton();
            $grid->tools(BatchOrderPrint::make());

            $grid->filter(function (Grid\Filter $filter) {
            });
        });
    }

    protected function setForm(Form &$form): void
    {
        $form->row(function (Form\Row $row) {
            $row->width(6)->text('order_no', '单号')->default(build_order_no('PD'))->required()->readOnly();
            $row->width(6)->text('created_at', '业务日期')->default(now())->required()->readOnly();
        });
        $form->row(function (Form\Row $row) use ($form) {
            if ($form->isEditing()) {
                $row->width(6)->select('with_id', '相关单据')->options(InventoryModel::query()->pluck(
                    'order_no',
                    'id'
                ))->disable();
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
    }

    public function setItems(Grid &$grid): void
    {
        $order = $this->order;
        $grid->column('stock_batch.sku.product.name', '产品名称');
        $grid->column('stock_batch.sku.attr_value_ids_str', '属性');
        $grid->column('stock_batch.batch_no', '批次号');
        $grid->column('stock_batch.percent', '含绒量');
        $grid->column('stock_batch.standard_str', '检验标准');
        $grid->column('cost_price', "成本单价");
        $grid->column('should_num', '库存数量');
        $grid->column("actual_num", "实盘数量")->if(function (Grid\Column $colum) use ($order) {
            return $order->status === InventoryOrderModel::REVIEW_STATUS_OK;
        })->display(function ($val) {
            return $val;
        })->else()->edit();
        $grid->column('diff_num', '盈亏数量');
        $grid->column("diff_cost_price", "盈亏金额")->display(function () {
            return bcmul($this->diff_num, $this->cost_price, 2);
        });
    }

    public function setItemsCommon(Grid &$grid): void
    {
        $grid->tools(OrderPrint::make());
        if ($this->order && $this->order->review_status !== $this->oredr_model::REVIEW_STATUS_OK) {
            $with_order = $this->order->with_order;
            $with_order->status === InventoryModel::STATUS_WAIT && $grid->tools(OrderReview::make(show_order_review($this->order->review_status)));
            $grid->tools(OrderDelete::make());
            $grid->tools(BatchStockSelect::make());
        }
        $grid->disableActions();
        $grid->disablePagination();
        $grid->disableCreateButton();
        $grid->disableBatchDelete();
    }
}
