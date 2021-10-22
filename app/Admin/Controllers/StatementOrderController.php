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

use App\Admin\Actions\Grid\BatchCustomerStatement;
use App\Admin\Actions\Grid\BatchOrderPrint;
use App\Admin\Actions\Grid\BatchSupplierStatement;
use App\Admin\Actions\Grid\Delete;
use App\Admin\Actions\Grid\EditOrder;
use App\Admin\Actions\Grid\OrderDelete;
use App\Admin\Actions\Grid\OrderPrint;
use App\Admin\Actions\Grid\OrderReview;
use App\Admin\Extensions\Form\Order\OrderController;
use App\Admin\Extensions\Grid\CostItemOrderDetail;
use App\Admin\Extensions\Grid\StatementDetail;
use App\Admin\Repositories\StatementOrder;
use App\Models\CostItemModel;
use App\Models\CustomerModel;
use App\Models\StatementOrderModel;
use App\Models\SupplierModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Builder;

class StatementOrderController extends OrderController
{
    public $item_relations = ['cost_order'];
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new StatementOrder(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('order_no');
            $grid->column('category', "费用分类")->using(StatementOrderModel::CATEGORY);
            $grid->column("_", "结算明细")->expand(StatementDetail::class);
            $grid->column('company_name', '公司名称');
            $grid->column('other')->emp();
            $grid->column('review_status', "审核状态")->using(StatementOrderModel::REVIEW_STATUS)->label(StatementOrderModel::REVIEW_STATUS_COLOR);
            $grid->column('should_amount');
            $grid->column('actual_amount');
            $grid->column('discount_amount');
            $grid->column('created_at');
            $grid->actions(EditOrder::make());
            $grid->disableQuickEditButton();
            $grid->disableCreateButton();
            $grid->tools([BatchOrderPrint::make(), BatchSupplierStatement::make(), BatchCustomerStatement::make(), Delete::make()]);

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('category', '费用分类')->width(4)->radio(StatementOrderModel::CATEGORY);
                $filter->group('should_amount', function ($group) {
                    $group->gt('大于');
                    $group->lt('小于');
                    $group->nlt('不小于');
                    $group->ngt('不大于');
                    $group->equal('等于');
                })->width(4);
                $filter->group('actual_amount', function ($group) {
                    $group->gt('大于');
                    $group->lt('小于');
                    $group->nlt('不小于');
                    $group->ngt('不大于');
                    $group->equal('等于');
                })->width(4);

                if (request()->exists('category') && request('category') == StatementOrderModel::CATEGORY_CUSTOMER) {
                    $filter->equal('company_id', "客户名称")->width(4)->select(CustomerModel::query()->latest()->pluck('name', 'id'));
                }
                if (request()->exists('category') && request('category') == StatementOrderModel::CATEGORY_SUPPLIER) {
                    $filter->equal('company_id', "供应商名称")->width(4)->select(SupplierModel::query()->latest()->pluck('name', 'id'));
                }
            });
            $grid->export()->rows(function (array $rows) {
                return array_map(function ($row) {
                    return [
                        '费用单号' => $row['order_no'],
                        '费用分类' => StatementOrderModel::CATEGORY[$row['category']],
                        '公司名称' => $row['company_name'],
                        '审核状态' => StatementOrderModel::REVIEW_STATUS[$row['review_status']],
                        '应付金额' => $row['should_amount'],
                        '实付金额' => $row['actual_amount'],
                        '优惠金额' => $row['discount_amount'],
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
            $row->width(6)->text('order_no', '单号')->default(build_order_no('JS'))->required()->readOnly();
            $row->width(6)->text('created_at', '业务日期')->default(now())->required()->readOnly();
        });
        $form->row(function (Form\Row $row) {
            $row->width(6)->text('category_str', '费用分类')->disable();
            $users = Administrator::query()->latest()->pluck('name', 'id');

            $row->width(6)->select('apply_id', '审批人')->options($users)->default(head($users->keys()->toArray()))->required();
        });
        $form->row(function (Form\Row $row) {
            $row->width(6)->text('should_amount', '应付金额')->readOnly();
            $row->width(6)->text('actual_amount', '实付金额')->readOnly();
        });

        $form->row(function (Form\Row $row) {
            $row->width(6)->text('discount_amount', '优惠金额')->disable();
            $row->width(6)->text('company_name', '公司名称')->disable();
        });

        $form->row(function (Form\Row $row) {
            $row->width(6)->text('other', '备注')->saveAsString();
        });
    }

    public function setItems(Grid &$grid): void
    {
        $order = $this->order;
        $grid->column('cost_order.order_no', '相关订单');
        $grid->column('order_amount', '订单金额');
        $grid->column('already_actual_amount', '已付款金额');
        $grid->column('already_discount_amount', '已优惠金额');

        $grid->column('should_amount', '本次应付金额');
        $grid->column('discount_amount', '本次优惠金额')->if(function (Grid\Column $column) use ($order) {
            return $order->review_status === StatementOrderModel::REVIEW_STATUS_OK;
        })->display(function ($val) {
            return $val;
        })->else()->edit();
        $grid->column("actual_amount", "本次付款金额")->if(function (Grid\Column $column) use ($order) {
            return $order->review_status === StatementOrderModel::REVIEW_STATUS_OK;
        })->display(function ($val) {
            return $val;
        })->else()->edit();
//        $grid->column('cost_type', "费用类型")->using(CostItemModel::COST_TYPE);
//        $grid->column('_', '订单详情')->expand(function () {
//            return CostItemOrderDetail::make(['with_id' => $this->with_id, 'cost_type' => $this->cost_type]);
//        });
//        $grid->column('should_amount', '费用金额');
    }

    public function creating(Form &$form): void
    {
        // TODO: Implement creating() method.
    }

    public function setItemsCommon(Grid &$grid): void
    {
        $grid->tools(OrderPrint::make());
        if ($this->order && $this->order->review_status !== $this->oredr_model::REVIEW_STATUS_OK) {
            $grid->tools(OrderReview::make(show_order_review($this->order->review_status)));
            $grid->tools(OrderDelete::make());
        }
        $grid->disableActions();
        $grid->disablePagination();
        $grid->disableCreateButton();
        $grid->disableBatchDelete();
    }
}
