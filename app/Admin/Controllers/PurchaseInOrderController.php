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

use App\Admin\Actions\Grid\BatchCreatePurInOrder;
use App\Admin\Actions\Grid\BatchOrderPrint;
use App\Admin\Actions\Grid\EditOrder;
use App\Admin\Extensions\Form\Order\OrderController;
use App\Admin\Repositories\PurchaseInOrder;
use App\Models\PositionModel;
use App\Models\ProductModel;
use App\Models\PurchaseOrderModel;
use App\Repositories\SupplierRepository;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Illuminate\Support\Fluent;

class PurchaseInOrderController extends OrderController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new PurchaseInOrder(['user', 'supplier', 'with_order']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('order_no');
            $grid->column('with_order.order_no', '关联单号')->emp();
            $grid->column('other')->emp();
            $grid->column('status', "单据状态")->using($this->oredr_model::STATUS)->label($this->oredr_model::STATUS_COLOR);
            $grid->column('review_status', '审核状态')->using($this->oredr_model::REVIEW_STATUS)->label($this->oredr_model::REVIEW_STATUS_COLOR);
            $grid->column('supplier.name', '供应商名称')->emp();
            $grid->column('user.username', '创建用户');
            $grid->column('created_at');
            $grid->column('apply_at', "审核时间")->emp();
            $grid->disableQuickEditButton();
            $grid->disableCreateButton();
            $grid->actions(EditOrder::make());
            $grid->tools(BatchOrderPrint::make());
            $grid->tools(BatchCreatePurInOrder::make());

            $grid->filter(function (Grid\Filter $filter) {
            });
        });
    }

    /**
     * @param Form $form
     */
    protected function setForm(Form &$form): void
    {
        $form->row(function (Form\Row $row) {
            $row->width(6)->text('order_no', '单号')->default(build_order_no('RK'))->required()->readOnly();
            $row->width(6)->text('created_at', '业务日期')->default(now())->required()->readOnly();
        });
        $with_order = $this->order_repository->getWithOrder();
        $form->row(function (Form\Row $row) use ($with_order) {
            $row->width(6)->select('status', '单据状态')->options([$this->oredr_model::STATUS_ARRIVE => '已收货'])->default($this->oredr_model::STATUS_ARRIVE)->required();
            $order = $this->order;
            $review_statu_ok = $this->oredr_model::REVIEW_STATUS_OK;
            if ($order && $order->review_status === $review_statu_ok) {
                $row->width(6)->select('with_id', '相关单据')->options(PurchaseOrderModel::query()->pluck('order_no', 'id'))->disable();
            } else {
                $row->width(6)->select('with_id', '相关采购单据')->options($with_order)->default(0)->required()->with_order();
            }
        });
        $form->row(function (Form\Row $row) {
            $supplier = SupplierRepository::pluck();
            $row->width(6)->select('supplier_id', '供应商')->options($supplier)->default(head($supplier->keys()->toArray()))->required();
            $row->width(6)->text('other', '备注')->saveAsString();
        });
    }

    /**
     * @param Form $form
     */
    protected function creating(Form &$form): void
    {
        $form->width(12)->row(function (Form\Row $row) {
            $row->hasMany('items', '', function (Form\NestedForm $table) {
                $table->select('product_id', '名称')->options(ProductModel::pluck('name', 'id'))->loadpku(route('api.product.find'))->required();
                $table->ipt('unit', '单位')->rem(3)->default('-')->disable();
                $table->select('sku_id', '属性选择')->options()->required();
                $table->tableDecimal('percent', '含绒百分比')->default(0);
                $table->select('standard', '检验标准')->options(PurchaseOrderModel::STANDARD)->default(0);
                $table->num('should_num', '采购数量')->required();
                $table->tableDecimal('price', '采购价格')->default(0.00)->required();
                $table->select('position_id', '入库位置')->options(PositionModel::orderBy('id', 'desc')->pluck('name', 'id'));
                $table->ipt('batch_no', '批次号')->rem(8)->default("PC".date('Ymd'))->required();
            })->useTable()->width(12)->enableHorizontal();
        });
    }

    /**
     * @param Grid $grid
     */
    public function setItems(Grid &$grid): void
    {
        $order = $this->order;
        $review_statu_ok = $this->oredr_model::REVIEW_STATUS_OK;

        $grid->column('sku.product.name', '产品名称');
        $grid->column('sku.product.unit.name', '单位');
        $grid->column('sku.product.type_str', '类型');

        $grid->column('sku_id', '属性')->if(function () use ($order,$review_statu_ok) {
            return $order->review_status === $review_statu_ok;
        })->display(function () {
            return $this->sku['attr_value_ids_str'] ?? '';
        })->else()->selectplus(function (Fluent $fluent) {
            return $fluent->sku['product']['sku_key_value'];
        });

        $grid->column('percent', '含绒百分比')->if(function () use ($order, $review_statu_ok) {
            return $order->review_status !== $review_statu_ok;
        })->edit();
        $grid->column('standard', '检验标准')->if(function () use ($order) {
            return $order->review_status === PurchaseOrderModel::REVIEW_STATUS_OK;
        })->display(function () {
            return PurchaseOrderModel::STANDARD[$this->standard];
        })->else()->selectplus(PurchaseOrderModel::STANDARD);

        $grid->column('position_id', '入库位置')->if(function () use ($order,$review_statu_ok) {
            return $order->review_status === $review_statu_ok;
        })->display(function ($val) {
            return PositionModel::whereId($val)->value('name') ?? '-';
        })->else()->selectplus(function () {
            return PositionModel::orderBy('id', 'desc')->pluck('name', 'id');
        });

        $grid->column('should_num', '采购数量');
        $grid->column('actual_num', '入库数量')->if(function () use ($order,$review_statu_ok) {
            return $order->review_status !== $review_statu_ok;
        })->edit();
        $grid->column('price', '采购价格')->if(function () use ($order,$review_statu_ok) {
            return $order->review_status !== $review_statu_ok;
        })->edit();
        $grid->column("_", '合计')->display(function () {
            return bcmul($this->actual_num, $this->price, 2);
        });

        $grid->column('batch_no', '批次号')->if(function () use ($order,$review_statu_ok) {
            return $order->review_status !== $review_statu_ok;
        })->edit();
    }
}
