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

namespace App\Observers;

use App\Models\CostItemModel;
use App\Models\CostOrderModel;
use App\Models\PurchaseOrderAmountModel;
use App\Models\SaleOrderAmountModel;

class CostOrderObserver
{
    public function saving(CostOrderModel $costOrderModel)
    {
        $costOrderModel->items->each(function (CostItemModel $costItemModel) use ($costOrderModel) {
            switch ($costItemModel->cost_type) {
                case CostItemModel::COST_TYPE_PURCHASE:
                    $amount = PurchaseOrderAmountModel::query()->where('order_id', $costItemModel->with_id)->firstOrFail();
                    $amount->accountant_id = $costOrderModel->accountant_item_id;
                    $amount->actual_amount = $costItemModel->actual_amount;
                    $amount->saveOrFail();
                    break;
                case CostItemModel::COST_TYPE_SALE:
                    $amount = SaleOrderAmountModel::query()->where('order_id', $costItemModel->with_id)->firstOrFail();
                    $amount->actual_amount = $costItemModel->actual_amount;
                    $amount->accountant_id = $costOrderModel->accountant_item_id;
                    $amount->saveOrFail();
                    break;
                default:
                    break;
            }
        });
    }
}
