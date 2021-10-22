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
use App\Admin\Actions\Grid\OrderPrint;
use App\Admin\Actions\Grid\OrderReview;
use App\Admin\Extensions\Form\Order\OrderController;
use App\Admin\Extensions\Grid\CostDetail;
use App\Admin\Extensions\Grid\CostItemOrderDetail;
use App\Admin\Repositories\CostOrder;
use App\Models\CostItemModel;
use App\Models\CostOrderModel;
use App\Models\CustomerModel;
use App\Models\SupplierModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Models\Administrator;

class CostOrderController extends OrderController
{
    public $item_relations = [];
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $yearMonth = $this->getOrderRepository()->getYearMonth();
        return Grid::make(new CostOrder(['accountant_item']), function (Grid $grid) use ($yearMonth) {
            $grid->column('id')->sortable();
            $grid->column('order_no', "费用单号");
            $grid->column("_", "费用明细")->expand(CostDetail::class);
            $grid->column('category', "费用分类")->using(CostOrderModel::CATEGORY);
            $grid->column('company_str', "公司名称");
            $grid->column("accountant_item.year_month", "费用月份")->emp();
            $grid->column('review_status', '审核状态')->using(CostOrderModel::REVIEW_STATUS)->label(CostOrderModel::REVIEW_STATUS_COLOR);
            $grid->column('other', '备注')->emp();
            $grid->column('total_amount', "费用总金额");
            $grid->column('settlement_amount', '已付款金额');
            $grid->column('discount_amount', '已优惠金额');
            $grid->column('created_at');

            $grid->actions(EditOrder::make());
            $grid->disableQuickEditButton();
            $grid->tools(BatchOrderPrint::make());
            $grid->disableCreateButton();

            $grid->filter(function (Grid\Filter $filter) use ($yearMonth) {
                $filter->equal('category', '费用分类')->width(4)->radio(CostOrderModel::CATEGORY);
                $filter->equal('accountant_item_id', "费用月份")->width(4)->select($yearMonth);
                if (request()->exists('category') && (int)request('category') === CostOrderModel::CATEGORY_CUSTOMER) {
                    $filter->equal('company_id', "客户名称")->width(4)->select(CustomerModel::query()->latest()->pluck('name', 'id'));
                }
                if (request()->exists('category') && (int)request('category') === CostOrderModel::CATEGORY_SUPPLIER) {
                    $filter->equal('company_id', "供应商名称")->width(4)->select(SupplierModel::query()->latest()->pluck('name', 'id'));
                }
            });

            $grid->export()->rows(function (array $rows) {
                return array_map(function ($row) {
                    return [
                        '费用单号' => $row['order_no'],
                        '费用分类' => CostOrderModel::CATEGORY[$row['category']],
                        '公司名称' => $row['company_name'],
                        '费用月份' => $row['accountant_item']['year_month'],
                        '审核状态' => CostOrderModel::REVIEW_STATUS[$row['review_status']],
                        '费用总金额' => $row['total_amount'],
                        '已付款金额' => $row['settlement_amount'],
                        '已优惠金额' => $row['discount_amount'],
                        '备注' => $row['other'],
                        '创建时间' => $row['created_at'],
                    ];
                }, $rows);
            })->extension("xlsx");
        });
    }

    protected function setForm(Form &$form): void
    {
        $form->row(function (Form\Row $row) {
            $row->width(6)->text('order_no', '单号')->default(build_order_no('FY'))->required()->readOnly();
            $row->width(6)->text('created_at', '业务日期')->default(now())->required()->readOnly();
        });
        $form->row(function (Form\Row $row) {
            $row->width(6)->text('category_str', '费用分类')->disable();
//            $row->width(0)->hidden('category');
            $users = Administrator::query()->latest()->pluck('name', 'id');

            $row->width(6)->select('apply_id', '审批人')->options($users)->default(head($users->keys()->toArray()))->required();
        });
        $form->row(function (Form\Row $row) {
            $row->width(6)->text('year_month', '费用月份')->disable();
            $row->width(6)->text('total_amount', '费用总金额')->readOnly();
        });

        $form->row(function (Form\Row $row) {
            $row->width(6)->text('company_str', '公司名称')->disable();
            $row->width(6)->text('other', '备注')->saveAsString();
        });
    }

    public function creating(Form &$form): void
    {
    }

    public function setItems(Grid &$grid): void
    {
        $order = $this->order;
        $grid->column('with_order_no', '相关订单');
        $grid->column('cost_type', "费用类型")->using(CostItemModel::COST_TYPE);
        $grid->column('_', '订单详情')->expand(function () {
            return CostItemOrderDetail::make(['with_id' => $this->with_id, 'cost_type' => $this->cost_type]);
        });
        $grid->column('should_amount', '费用金额');
        $grid->column("actual_amount", "实际金额")->if(function (Grid\Column $column) use ($order) {
            return $order->review_status === CostOrderModel::REVIEW_STATUS_OK;
        })->display(function ($val) {
            return $val;
        })->else()->edit();
    }

    public function setItemsCommon(Grid &$grid): void
    {
        $grid->tools(OrderPrint::make());
        if ($this->order && $this->order->review_status !== $this->oredr_model::REVIEW_STATUS_OK) {
            $grid->tools(OrderReview::make(show_order_review($this->order->review_status)));
        }
        $grid->disableRowSelector();
        $grid->disableActions();
        $grid->disablePagination();
        $grid->disableCreateButton();
        $grid->disableBatchDelete();
    }
}
