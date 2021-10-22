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

use App\Models\SaleOrderModel;
use App\Models\SaleOutBatchModel;
use App\Models\SaleOutItemModel;
use App\Models\SaleOutOrderModel;
use App\Models\SkuStockModel;
use App\Models\StockHistoryModel;
use Dcat\Admin\Admin;

class SaleOutOrderObserver
{
    /**
     * Handle the sale out order model "created" event.
     *
     * @param  \App\Models\SaleOutOrderModel $saleOutOrderModel
     * @return void
     */
    public function created(SaleOutOrderModel $saleOutOrderModel): void
    {
        //
    }

    /**
     * Handle the sale out order model "updated" event.
     *
     * @param  \App\Models\SaleOutOrderModel $saleOutOrderModel
     * @return void
     */
    public function updated(SaleOutOrderModel $saleOutOrderModel): void
    {
        //
    }

    /**
     * Handle the sale out order model "deleted" event.
     *
     * @param  \App\Models\SaleOutOrderModel $saleOutOrderModel
     * @return void
     */
    public function deleted(SaleOutOrderModel $saleOutOrderModel): void
    {
        //
    }

    /**
     * Handle the sale out order model "restored" event.
     *
     * @param  \App\Models\SaleOutOrderModel $saleOutOrderModel
     * @return void
     */
    public function restored(SaleOutOrderModel $saleOutOrderModel): void
    {
        //
    }

    /**
     * Handle the sale out order model "force deleted" event.
     *
     * @param  \App\Models\SaleOutOrderModel $saleOutOrderModel
     * @return void
     */
    public function forceDeleted(SaleOutOrderModel $saleOutOrderModel): void
    {
        //
    }

    /**
     * @param SaleOutOrderModel $saleOutOrderModel
     */
    public function creating(SaleOutOrderModel $saleOutOrderModel): void
    {
        $saleOutOrderModel->user_id = Admin::user()->id;
    }

    public function saving(SaleOutOrderModel $saleOutOrderModel): void
    {
        if ($saleOutOrderModel->isDirty('review_status')
            && (int)$saleOutOrderModel->review_status === SaleOutOrderModel::REVIEW_STATUS_OK
            && (int)$saleOutOrderModel->status === SaleOutOrderModel::STATUS_SEND
        ) {
            $saleOutOrderModel->items->each(function (SaleOutItemModel $saleOutItemModel) use ($saleOutOrderModel) {
                $saleOutItemModel->sum_price = bcmul($saleOutItemModel->actual_num, $saleOutItemModel->price, 2);
                $saleOutItemModel->profit = bcsub($saleOutItemModel->sum_price, $saleOutItemModel->sum_cost_price, 2);
                $saleOutItemModel->saveOrFail();
                $saleOutItemModel->batchs->each(function (SaleOutBatchModel $saleOutBatchModel) use ($saleOutItemModel, $saleOutOrderModel) {
                    $init_num = SkuStockModel::where([
                        'sku_id' => $saleOutItemModel->sku_id,
                        'percent' => $saleOutItemModel->percent,
                        'standard'       => $saleOutItemModel->standard,
                    ])->value('num');

                    StockHistoryModel::create([
                        'sku_id'          => $saleOutItemModel->sku_id,
                        'out_position_id' => $saleOutBatchModel->stock_batch->position_id,
                        'cost_price'      => $saleOutBatchModel->stock_batch->cost_price,
                        'type'            => StockHistoryModel::STORE_OUT_TYPE,
                        'flag'            => StockHistoryModel::OUT,
                        'with_order_no'   => $saleOutOrderModel->order_no,
                        'init_num'        => $init_num,
                        'out_num'         => $saleOutBatchModel->actual_num,
                        'out_price'       => $saleOutItemModel->price,
                        'balance_num'     => $init_num - $saleOutBatchModel->actual_num,
                        'percent'         => $saleOutItemModel->percent,
                        'standard'        => $saleOutItemModel->standard,
                        'user_id'         => Admin::user()->id,
                        'batch_no'        => $saleOutBatchModel->stock_batch->batch_no,
                    ]);
                });
            });
            $saleOutOrderModel->with_order->status = SaleOrderModel::STATUS_SEND;
            $saleOutOrderModel->with_order->save();
            $saleOutOrderModel->apply_at = now();
            $saleOutOrderModel->amount()->create([
                'customer_id' => $saleOutOrderModel->customer_id,
                'should_amount' => $saleOutOrderModel->items->reduce(function (float $amount, SaleOutItemModel $itemModel) {
                    $sumPrice = bcmul($itemModel->price, $itemModel->actual_num, 5);
                    return bcadd($sumPrice, $amount, 5);
                }, 0),
            ]);
        }
    }
}
