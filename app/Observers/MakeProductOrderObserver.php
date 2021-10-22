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

use App\Models\MakeProductOrderModel;
use App\Models\SkuStockModel;
use App\Models\StockHistoryModel;
use App\Models\TaskModel;
use Dcat\Admin\Admin;

class MakeProductOrderObserver
{
    public function saving(MakeProductOrderModel $makeProductOrderModel): void
    {
        if ($makeProductOrderModel->isDirty('review_status')
            && (int)$makeProductOrderModel->review_status === MakeProductOrderModel::REVIEW_STATUS_OK
        ) {
            $item = $makeProductOrderModel->items;
            $item->sum_cost_price = bcmul($item->actual_num, $item->cost_price, 2);
            $item->saveOrFail();

            $init_num = SkuStockModel::query()
                ->where([
                    'sku_id' => $item->sku_id,
                    'percent' => $item->percent,
                    'standard'       => $item->standard,
                ])->value('num');

            StockHistoryModel::create([
                'sku_id'         => $item->sku_id,
                'in_position_id' => $item->position_id,
                'cost_price'     => $item->cost_price,
                'type'           => StockHistoryModel::PRO_STOCK_TYPE,
                'flag'           => StockHistoryModel::IN,
                'with_order_no'  => $makeProductOrderModel->order_no,
                'init_num'       => $init_num ?? 0,
                'in_num'         => $item->actual_num,
                'in_price'       => $item->cost_price,
                'balance_num'    => $init_num + $item->actual_num,
                'standard'       => $item->standard,
                'user_id'        => Admin::user()->id,
                'percent'        => $item->percent,
                'batch_no'       => $item->batch_no,
            ]);
            $makeProductOrderModel->with_order->status = TaskModel::STATUS_FINISH;
            $makeProductOrderModel->with_order->finish_num = $item->actual_num;
            $makeProductOrderModel->with_order->save();
        }
    }
    /**
     * @param  MakeProductOrderModel  $makeProductOrderModel
     */
    public function creating(MakeProductOrderModel $makeProductOrderModel): void
    {
        $makeProductOrderModel->user_id = Admin::user()->id;
    }
}
