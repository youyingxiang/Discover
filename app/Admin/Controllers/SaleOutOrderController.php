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

use App\Admin\Actions\Grid\BatchCreateSaleOutOrder;
use App\Admin\Actions\Grid\BatchOrderPrint;
use App\Admin\Actions\Grid\EditOrder;
use App\Admin\Extensions\Form\Order\OrderController;
use App\Admin\Extensions\Grid\BatchDeail;
use App\Admin\Repositories\SaleOutOrder;
use App\Models\PurchaseOrderModel;
use App\Models\SaleOrderModel;
use App\Models\SaleOutOrderModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Illuminate\Support\Fluent;

class SaleOutOrderController extends OrderController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SaleOutOrder(['customer', 'user']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('customer.name', '客户');

            $grid->column('order_no');
            $grid->column('other')->emp();
            $grid->column('user.name', '创建用户');
            $grid->column('status', "单据状态")->using($this->oredr_model::STATUS)->label($this->oredr_model::STATUS_COLOR);
            $grid->column('review_status', '审核状态')->using($this->oredr_model::REVIEW_STATUS)->label($this->oredr_model::REVIEW_STATUS_COLOR);
            $grid->column('created_at');
            $grid->column('apply_at', "审核时间")->emp();
            $grid->disableQuickEditButton();
            $grid->disableCreateButton();
            $grid->actions(EditOrder::make());
            $grid->tools(BatchOrderPrint::make());
            $grid->tools(BatchCreateSaleOutOrder::make());

            $grid->filter(function (Grid\Filter $filter) {
            });
        });
    }

    protected function setForm(Form &$form): void
    {
        $form->row(function (Form\Row $row) {
            $row->width(6)->text('order_no', '单号')->default(build_order_no('CH'))->required()->readOnly();
            $row->width(6)->text('created_at', '业务日期')->default(now())->required()->readOnly();
        });
        $with_order = $this->order_repository->getWithOrder();
        $form->row(function (Form\Row $row) use ($with_order) {
            $order = $this->order;
            $review_statu_ok = $this->oredr_model::REVIEW_STATUS_OK;
            if ($order && $order->review_status === $review_statu_ok) {
                $row->width(6)->select('status', '单据状态')->options(SaleOutOrderModel::STATUS)->default($this->oredr_model::STATUS_SEND)->required();
                $row->width(6)->select('with_id', '相关单据')->options(SaleOrderModel::query()->pluck('order_no', 'id'))->disable();
            } else {
                $row->width(6)->select('status', '单据状态')->options([$this->oredr_model::STATUS_SEND => '已发送'])->default($this->oredr_model::STATUS_SEND)->required();
                $row->width(6)->select('with_id', '相关单据')->options($with_order)->default(0)->required()->with_order();
            }
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
            $row->width(6)->text('other', '备注')->saveAsString();
        });
    }

    protected function setItems(Grid &$grid): void
    {
        $order = $this->order;
        $grid->column('sku.product.name', '产品名称');
        $grid->column('sku.product.unit.name', '单位');
        $grid->column('sku.product.type_str', '类型');
        $grid->column('sku_id', '属性')->if(function () use ($order) {
            return $order->review_status === SaleOutOrderModel::REVIEW_STATUS_OK;
        })->display(function () {
            return $this->sku['attr_value_ids_str'] ?? '';
        })->else()->selectplus(function (Fluent $fluent) {
            return $fluent->sku['product']['sku_key_value'];
        });

        $grid->column('percent', '含绒百分比')->if(function () use ($order) {
            return $order->review_status !== SaleOutOrderModel::REVIEW_STATUS_OK;
        })->edit();

        $grid->column('standard', '检验标准')->if(function () use ($order) {
            return $order->review_status === SaleOutOrderModel::REVIEW_STATUS_OK;
        })->display(function () {
            return PurchaseOrderModel::STANDARD[$this->standard];
        })->else()->selectplus(SaleOutOrderModel::STANDARD);
        $grid->column('sku_stock_num', "库存参考数量")->display(function ($val) {
            return $val;
        });

        $grid->column('should_num', '要货数量');
        $grid->column('actual_num', '销售数量');
        $grid->column('price', '销售价格')->if(function () use ($order) {
            return $order->review_status !== SaleOutOrderModel::REVIEW_STATUS_OK;
        })->edit();
        $grid->column("_", '合计')->display(function () {
            return bcmul($this->actual_num, $this->price, 2);
        });
        $grid->column('pcxq', '批次详情')->batch_detail(function (BatchDeail $batchDeail) {
            return route('sale-out-batchs.index', [
                Grid::IFRAME_QUERY_NAME => 1,
                'item_id'               => $batchDeail->row->id,
                'sku_id'                => $batchDeail->row->sku_id,
                'standard'              => $batchDeail->row->standard,
                'percent'               => $batchDeail->row->percent,
            ]);
        });
    }

    protected function creating(Form &$form): void
    {
    }
}
