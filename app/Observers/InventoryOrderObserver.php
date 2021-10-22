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

use App\Models\InventoryItemModel;
use App\Models\InventoryModel;
use App\Models\InventoryOrderModel;
use App\Models\SkuStockModel;
use App\Models\StockHistoryModel;
use Dcat\Admin\Admin;

class InventoryOrderObserver
{
    public function deleting(InventoryOrderModel $inventoryOrderModel)
    {
        $inventoryOrderModel->items()->delete();
    }

    public function updating(InventoryOrderModel $inventoryOrderModel)
    {
        $inventoryOrderModel->with_id = $inventoryOrderModel->getOriginal('with_id');
    }

    public function saving(InventoryOrderModel $inventoryOrderModel): void
    {
        if ($inventoryOrderModel->isDirty('review_status')
            && (int)$inventoryOrderModel->review_status === InventoryOrderModel::REVIEW_STATUS_OK
        ) {
            $inventoryOrderModel->items->each(function (InventoryItemModel $item) use ($inventoryOrderModel) {
                $init_num = SkuStockModel::query()
                    ->where([
                        'sku_id' => $item->stock_batch->sku_id,
                        'percent' => $item->stock_batch->percent,
                        'standard' => $item->stock_batch->standard,
                    ])->value('num');
                StockHistoryModel::create([
                    'sku_id' => $item->stock_batch->sku_id,
                    'in_position_id' => $item->stock_batch->position_id,
                    'cost_price' => $item->cost_price,
                    'type' => StockHistoryModel::INVENTORY_TYPE,
                    'flag' => StockHistoryModel::INVENTORY,
                    'with_order_no' => $inventoryOrderModel->order_no,
                    'init_num' => $init_num ?? 0,
                    'inventory_num' => $item->actual_num,
                    'inventory_diff_num' => $item->diff_num,
                    'balance_num' => $item->actual_num,
                    'standard' => $item->stock_batch->standard,
                    'user_id' => Admin::user()->id,
                    'percent' => $item->stock_batch->percent,
                    'batch_no' => $item->stock_batch->batch_no,
                ]);
            });

            $inventoryOrderModel->with_order->status = InventoryModel::STATUS_FINISH;
            $inventoryOrderModel->with_order->save();
        }
    }
}
