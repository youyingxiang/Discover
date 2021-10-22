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

use App\Admin\Repositories\Demand;
use App\Http\Requests\MonthSettlementRequest;
use App\Models\AccountantDateItemModel;
use App\Models\CostItemModel;
use App\Models\CostOrderModel;
use App\Models\CustomerModel;
use App\Models\PurchaseOrderAmountModel;
use App\Models\SaleOrderAmountModel;
use App\Models\SupplierModel;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Traits\HasFormResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Yxx\LaravelQuick\Exceptions\Api\ApiRequestException;

class MonthSettlementController extends AdminController
{
    use HasFormResponse;
    public function create(Content $content)
    {
        return $content
            ->title('月结')
            ->description("月结")
            ->body($this->form());
    }

    protected function form()
    {
        return Form::make(new Demand(), function (Form $form) {
            $accountant = AccountantDateItemModel::query()->latest()->get()
                ->filter(function (AccountantDateItemModel $itemModel) {
                    return Carbon::create($itemModel->accountant_date->year, $itemModel->month)->startOfMonth() < now()->startOfMonth();
                })->map(function (AccountantDateItemModel $itemModel) {
                    return [
                        'yearmonth' => $itemModel->year_month,
                        'id' => $itemModel->id,
                    ];
                })->sortByDesc('yearmonth')->pluck('yearmonth', 'id');
            $form->select('accountant_item_id', "结算期")->options($accountant)->default($accountant->keys()->first())->required();
            $form->radio("type", "结算类型")->options(CostOrderModel::CATEGORY)->default(CostOrderModel::CATEGORY_CUSTOMER)->when(CostOrderModel::CATEGORY_CUSTOMER, function (Form $form) {
                $form->multipleSelect("customers", "客户")->options(CustomerModel::query()->latest()->pluck(
                    'name',
                    'id'
                ))->required();
            })->when(CostOrderModel::CATEGORY_SUPPLIER, function (Form $form) {
                $form->multipleSelect("suppliers", "供应商")->options(SupplierModel::query()->latest()->pluck(
                    'name',
                    'id'
                ))->required();
            })->required();
        })->title("财务月结")
            ->action(route('month-settlements.settlement'))
            ->disableListButton()
            ->disableViewCheck()
            ->disableCreatingCheck()
            ->disableEditingCheck();
    }

    public function settlement(MonthSettlementRequest $request)
    {
        $accountantItemId = $request->input('accountant_item_id');
        $accountantItem = AccountantDateItemModel::query()->findOrFail($accountantItemId);
        $type = $request->input('type');
        if ($type == CostOrderModel::CATEGORY_CUSTOMER) {
            $customers = array_filter($request->input('customers'), function ($val) {
                return $val !== null;
            });
            if (! $customers) {
                throw new ApiRequestException("请选择要结算的客户 !");
            }

            foreach ($customers as $customer) {
                $amounts = SaleOrderAmountModel::query()
                    ->where("customer_id", $customer)
                    ->where('status', SaleOrderAmountModel::STATUS_NO)
                    ->where(function (Builder $builder) use ($accountantItem) {
                        $builder->where('created_at', ">=", $accountantItem->start_at);
                        $builder->where('created_at', "<=", $accountantItem->end_at);
                    })->get();

                if ($amounts->count() === 0) {
                    continue;
                }

                $totalAmount = $amounts->sum('should_amount');

                DB::transaction(function () use ($customer,$accountantItemId, $totalAmount, $amounts) {
                    $items = $amounts->map(function (SaleOrderAmountModel $amountModel) {
                        $amountModel->status = SaleOrderAmountModel::STATUS_OK;
                        $amountModel->saveOrFail();
                        return [
                            "cost_type" => CostItemModel::COST_TYPE_SALE,
                            'should_amount' => $amountModel->should_amount,
                            'actual_amount' => $amountModel->should_amount,
                            'with_id' => $amountModel->order_id,
                            'with_order_no' => $amountModel->order->order_no,
                        ];
                    });

                    $costOrder = CostOrderModel::query()->create([
                        'order_no' => build_order_no('FY'),
                        'category' => CostOrderModel::CATEGORY_CUSTOMER,
                        'company_id' => $customer,
                        'user_id' => Admin::user()->id,
                        'apply_id' => Admin::user()->id,
                        'accountant_item_id' => $accountantItemId,
                        'total_amount' => $totalAmount,
                        'company_name' => CustomerModel::query()->where('id', $customer)->value('name') ?? '',
                    ]);
                    $costOrder->items()->createMany($items);
                });
            }
        } elseif ($type == CostOrderModel::CATEGORY_SUPPLIER) {
            $suppliers = array_filter($request->input('suppliers'), function ($val) {
                return $val !== null;
            });
            if (! $suppliers) {
                throw new ApiRequestException("请选择要结算的供应商 !");
            }
            foreach ($suppliers as $supplier) {
                $amounts = PurchaseOrderAmountModel::query()
                    ->where("supplier_id", $supplier)
                    ->where('status', PurchaseOrderAmountModel::STATUS_NO)
                    ->where(function (Builder $builder) use ($accountantItem) {
                        $builder->where('created_at', ">=", $accountantItem->start_at);
                        $builder->where('created_at', "<=", $accountantItem->end_at);
                    })->get();
                if ($amounts->count() === 0) {
                    continue;
                }
                $totalAmount = $amounts->sum('should_amount');

                DB::transaction(function () use ($supplier,$accountantItemId, $totalAmount, $amounts) {
                    $items = $amounts->map(function (PurchaseOrderAmountModel $amountModel) {
                        $amountModel->status = PurchaseOrderAmountModel::STATUS_OK;
                        $amountModel->saveOrFail();
                        return [
                            "cost_type" => CostItemModel::COST_TYPE_PURCHASE,
                            'should_amount' => $amountModel->should_amount,
                            'actual_amount' => $amountModel->should_amount,
                            'with_id' => $amountModel->order_id,
                            'with_order_no' => $amountModel->order->order_no,
                        ];
                    });
                    $costOrder = CostOrderModel::query()->create([
                        'order_no' => build_order_no('FY'),
                        'category' => CostOrderModel::CATEGORY_SUPPLIER,
                        'company_id' => $supplier,
                        'user_id' => Admin::user()->id,
                        'apply_id' => Admin::user()->id,
                        'accountant_item_id' => $accountantItemId,
                        'total_amount' => $totalAmount,
                        'company_name' => SupplierModel::query()->where('id', $supplier)->value('name') ?? '',
                    ]);
                    $costOrder->items()->createMany($items);
                });
            }
        }
        return $this->ajaxResponse("月结成功", route('cost-orders.index'));
    }
}
