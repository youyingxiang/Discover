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

use App\Admin\Actions\Grid\BatchCreatePurInOrderSave;
use App\Admin\Actions\Grid\BatchOrderPrint;
use App\Admin\Actions\Grid\EditOrder;
use App\Admin\Extensions\Form\Order\OrderController;
use App\Admin\Repositories\PurchaseOrder;
use App\Models\ProductModel;
use App\Models\PurchaseOrderModel;
use App\Repositories\SupplierRepository;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Illuminate\Support\Fluent;

class PurchaseOrderController extends OrderController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new PurchaseOrder(['user', 'supplier']), function (Grid $grid) {
            $grid->column('id')->sortable();
//            $grid->column('check_status')->using(PurchaseOrderModel::CHECK_STATUS);
            $grid->column('order_no');
            $grid->column('other')->emp();
            $grid->column('status', '状态')->using(PurchaseOrderModel::STATUS)->label(PurchaseOrderModel::STATUS_COLOR);
            $grid->column('review_status', '审核状态')->using(PurchaseOrderModel::REVIEW_STATUS)->label(PurchaseOrderModel::REVIEW_STATUS_COLOR);
            $grid->column('supplier.name', '供应商名称')->emp();
            $grid->column('user.username', '创建用户');
            $grid->column('created_at');
            $grid->column('finished_at')->emp();
            $grid->tools(BatchOrderPrint::make());
            $grid->disableQuickEditButton();
            $grid->actions(new EditOrder());
            $grid->filter(function (Grid\Filter $filter) {
            });
        });
    }

    public function iFrameGrid()
    {
        return Grid::make(new PurchaseOrder(['user', 'supplier']), function (Grid $grid) {
            $grid->model()->where([
                'status'        => PurchaseOrderModel::STATUS_WAIT,
                'review_status' => PurchaseOrderModel::REVIEW_STATUS_OK
            ])->orderBy('id', 'desc');

            $grid->column('id')->sortable();
//            $grid->column('check_status')->using(PurchaseOrderModel::CHECK_STATUS);

            $grid->column('order_no');
            $grid->column('other')->emp();
            $grid->column('status', '状态')->using(PurchaseOrderModel::STATUS)->label(PurchaseOrderModel::STATUS_COLOR);
            $grid->column('review_status', '审核状态')->using(PurchaseOrderModel::REVIEW_STATUS)->label(PurchaseOrderModel::REVIEW_STATUS_COLOR);
            $grid->column('supplier.name', '供应商名称')->emp();
            $grid->column('user.username', '创建用户');
            $grid->column('created_at');
            $grid->column('finished_at')->emp();
            $grid->disableQuickEditButton();
            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->tools(BatchCreatePurInOrderSave::make());
            $grid->filter(function (Grid\Filter $filter) {
            });
        });
    }

    protected function setForm(Form &$form): void
    {
        $form->row(function (Form\Row $row) {
            $row->width(6)->text('order_no', '单号')->default(build_order_no('CG'))->required()->readOnly();
            $row->width(6)->text('created_at', '业务日期')->default(now())->required()->readOnly();
        });
        $form->row(function (Form\Row $row) {
            $order = $this->order;
            //$row->width(6)->select('check_status', '检测状态')->options(PurchaseOrderModel::CHECK_STATUS)->default(0)->required();
            if ($order && $order->review_status === PurchaseOrderModel::REVIEW_STATUS_OK) {
                $row->width(6)->select('status', '单据状态')->options(PurchaseOrderModel::STATUS)->default($this->oredr_model::STATUS_WAIT)->required();
            } else {
                $row->width(6)->select('status', '单据状态')->options([PurchaseOrderModel::STATUS_WAIT => '待收货'])->default(PurchaseOrderModel::STATUS_WAIT)->required();
            }
            $supplier = SupplierRepository::pluck();
            $row->width(6)->select('supplier_id', '供应商')->options($supplier)->default(head($supplier->keys()->toArray()))->required();
        });
        $form->row(function (Form\Row $row) {
            $row->width(6)->text('other', '备注')->saveAsString();
        });
    }

    protected function creating(Form &$form): void
    {
        $form->row(function (Form\Row $row) {
            $row->hasMany('items', '', function (Form\NestedForm $table) {
                $table->select('product_id', '名称')->options(ProductModel::pluck('name', 'id'))->loadpku(route('api.product.find'))->required();
                $table->ipt('unit', '单位')->rem(3)->default('-')->disable();
                $table->ipt('type', '类型')->rem(5)->default('-')->disable();
                $table->select('sku_id', '属性选择')->options()->required();
                $table->tableDecimal('percent', '含绒量')->default(0);
                $table->select('standard', '检验标准')->options(PurchaseOrderModel::STANDARD)->default(0);
                $table->num('should_num', '采购数量')->required();
                $table->tableDecimal('price', '采购价格')->default(0.00)->required();
            })->useTable()->width(12)->enableHorizontal();
        });
    }

    protected function setItems(Grid &$grid): void
    {
        $order = $this->order;
        $grid->column('sku.product.name', '产品名称');
        $grid->column('sku.product.unit.name', '单位');
        $grid->column('sku.product.type_str', '类型');
        $grid->column('sku_id', '属性')->if(function () use ($order) {
            return $order->review_status === PurchaseOrderModel::REVIEW_STATUS_OK;
        })->display(function () {
            return $this->sku['attr_value_ids_str'] ?? '';
        })->else()->selectplus(function (Fluent $fluent) {
            return $fluent->sku['product']['sku_key_value'];
        });
        $grid->column('percent', '含绒量')->if(function () use ($order) {
            return $order->review_status !== PurchaseOrderModel::REVIEW_STATUS_OK;
        })->edit();

        $grid->column('standard', '检验标准')->if(function () use ($order) {
            return $order->review_status === PurchaseOrderModel::REVIEW_STATUS_OK;
        })->display(function () {
            return PurchaseOrderModel::STANDARD[$this->standard];
        })->else()->select(PurchaseOrderModel::STANDARD);

        $grid->column('should_num', '采购数量')->if(function () use ($order) {
            return $order->review_status !== PurchaseOrderModel::REVIEW_STATUS_OK;
        })->edit();
        $grid->column('price', '采购价格')->if(function () use ($order) {
            return $order->review_status !== PurchaseOrderModel::REVIEW_STATUS_OK;
        })->edit();
        $grid->column("_", '合计')->display(function () {
            return bcmul($this->should_num, $this->price, 2);
        });
    }
}
