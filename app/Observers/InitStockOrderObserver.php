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

use App\Models\InitStockItemModel;
use App\Models\InitStockOrderModel;
use App\Models\SkuStockModel;
use App\Models\StockHistoryModel;
use Dcat\Admin\Admin;

class InitStockOrderObserver
{
    public function creating(InitStockOrderModel $initStockOrderModel)
    {
        $initStockOrderModel->user_id = Admin::user()->id;
    }

    public function saving(InitStockOrderModel $initStockOrderModel): void
    {
        if ($initStockOrderModel->isDirty('review_status')
            && (int)$initStockOrderModel->review_status === InitStockOrderModel::REVIEW_STATUS_OK
        ) {
            $initStockOrderModel->items->each(function (InitStockItemModel $item) use ($initStockOrderModel) {
                $init_num = SkuStockModel::query()
                    ->where([
                        'sku_id' => $item->sku_id,
                        'percent' => $item->percent,
                        'standard' => $item->standard,
                    ])->value('num');
                StockHistoryModel::create([
                    'sku_id' => $item->sku_id,
                    'in_position_id' => $item->position_id,
                    'cost_price' => $item->cost_price,
                    'type' => StockHistoryModel::INIT_TYPE,
                    'flag' => StockHistoryModel::IN,
                    'with_order_no' => $initStockOrderModel->order_no,
                    'init_num' => $init_num ?? 0,
                    'in_num' => $item->actual_num,
                    'balance_num' => $init_num + $item->actual_num,
                    'standard' => $item->standard,
                    'user_id' => Admin::user()->id,
                    'percent' => $item->percent,
                    'batch_no' => $item->batch_no,
                ]);
            });
        }
    }
}
