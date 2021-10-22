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

use App\Admin\Actions\Grid\BatchCreateSaleOutOrderSave;
use App\Admin\Actions\Grid\BatchOrderPrint;
use App\Admin\Actions\Grid\EditOrder;
use App\Admin\Extensions\Form\Order\OrderController;
use App\Admin\Repositories\SaleOrder;
use App\Models\ProductModel;
use App\Models\PurchaseOrderModel;
use App\Models\SaleOrderModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Illuminate\Support\Fluent;

class SaleOrderController extends OrderController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SaleOrder(['customer', 'user']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('customer.name', '客户');

            $grid->column('order_no');
            $grid->column('other')->emp();
            $grid->column('user.name', '创建用户');
            $grid->column('status', '单据状态')->using($this->oredr_model::STATUS)->label($this->oredr_model::STATUS_COLOR);
            $grid->column('review_status', '审核状态')->using($this->oredr_model::REVIEW_STATUS)->label($this->oredr_model::REVIEW_STATUS_COLOR);
            $grid->column('created_at');
            $grid->column('finished_at', "完成日期")->emp();

            $grid->disableQuickEditButton();
            $grid->tools(BatchOrderPrint::make());
            $grid->actions(EditOrder::make());

            $grid->filter(function (Grid\Filter $filter) {
            });
        });
    }

    public function iFrameGrid()
    {
        return Grid::make(new SaleOrder(['customer', 'user']), function (Grid $grid) {
            $grid->model()->where([
                'status'        => SaleOrderModel::STATUS_DOING,
                'review_status' => SaleOrderModel::REVIEW_STATUS_OK
            ])->orderBy('id', 'desc');

            $grid->column('id')->sortable();
            $grid->column('customer.name', '客户');

            $grid->column('order_no');
            $grid->column('other')->emp();
            $grid->column('user.name', '创建用户');
            $grid->column('status', '状态')->using($this->oredr_model::STATUS)->label($this->oredr_model::STATUS_COLOR);
            $grid->column('review_status', '审核状态')->using($this->oredr_model::REVIEW_STATUS)->label($this->oredr_model::REVIEW_STATUS_COLOR);
            $grid->column('created_at');
            $grid->column('finished_at')->emp();
            $grid->tools(BatchCreateSaleOutOrderSave::make());

            $grid->disableActions();
            $grid->disableCreateButton();

            $grid->filter(function (Grid\Filter $filter) {
            });
        });
    }

    /**
     * @param Grid $grid
     */
    protected function setItems(Grid &$grid): void
    {
        $order = $this->order;
        $grid->column('sku.product.name', '产品名称');
        $grid->column('sku.product.unit.name', '单位');
        $grid->column('sku.product.type_str', '类型');
        $grid->column('sku_id', '属性')->if(function () use ($order) {
            return $order->review_status === SaleOrderModel::REVIEW_STATUS_OK;
        })->display(function () {
            return $this->sku['attr_value_ids_str'] ?? '';
        })->else()->selectplus(function (Fluent $fluent) {
            return $fluent->sku['product']['sku_key_value'];
        });

        $grid->column('percent', '含绒百分比')->if(function () use ($order) {
            return $order->review_status !== SaleOrderModel::REVIEW_STATUS_OK;
        })->edit();

        $grid->column('standard', '检验标准')->if(function () use ($order) {
            return $order->review_status === SaleOrderModel::REVIEW_STATUS_OK;
        })->display(function () {
            return PurchaseOrderModel::STANDARD[$this->standard];
        })->else()->select(SaleOrderModel::STANDARD);

        $grid->column('should_num', '要货数量')->if(function () use ($order) {
            return $order->review_status !== SaleOrderModel::REVIEW_STATUS_OK;
        })->edit();
        $grid->column('price', '要货价格')->if(function () use ($order) {
            return $order->review_status !== SaleOrderModel::REVIEW_STATUS_OK;
        })->edit();
        $grid->column("_", '合计')->display(function () {
            return bcmul($this->should_num, $this->price, 2);
        });
    }

    /**
     * @param Form $form
     */
    protected function setForm(Form &$form): void
    {
        $form->row(function (Form\Row $row) {
            $row->width(6)->text('order_no', '单号')->default(build_order_no('YH'))->required()->readOnly();
            $row->width(6)->text('created_at', '业务日期')->default(now())->required()->readOnly();
        });

        $form->row(function (Form\Row $row) {
            $order = $this->order;
            $review_statu_ok = $this->oredr_model::REVIEW_STATUS_OK;
            if ($order && $order->review_status === $review_statu_ok) {
                $row->width(6)->select('status', '单据状态')->options(SaleOrderModel::STATUS)->default($this->oredr_model::STATUS_DOING)->required();
            } else {
                $row->width(6)->select('status', '单据状态')->options([$this->oredr_model::STATUS_DOING => '受理中'])->default($this->oredr_model::STATUS_DOING)->required();
            }
            $row->width(6)->text('other', '备注')->saveAsString();
        });
        $customer = $form->repository()->customer();
        $form->row(function (Form\Row $row) use ($customer) {
            $row->width(6)->select('customer_id', '客户')->options($customer)->loads(
                ['address_id', 'drawee_id'],
                [route('api.customer.address.find'), route('api.customer.drawee.find')]
            )->required();
            $row->width(6)->select('address_id', '地址')->required();
        });

        $form->row(function (Form\Row $row) {
            $row->width(6)->select('drawee_id', '付款人')->required();
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
                $table->num('should_num', '要货数量')->required();
                $table->tableDecimal('price', '要货价格')->default(0.00)->required();
            })->useTable()->width(12)->enableHorizontal();
        });
    }
}
