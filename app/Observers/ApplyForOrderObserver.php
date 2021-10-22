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

use App\Models\ApplyForBatchModel;
use App\Models\ApplyForItemModel;
use App\Models\ApplyForOrderModel;
use App\Models\SaleOutOrderModel;
use App\Models\SkuStockModel;
use App\Models\StockHistoryModel;
use App\Models\TaskModel;
use Dcat\Admin\Admin;

class ApplyForOrderObserver
{
    public function creating(ApplyForOrderModel $applyForOrderModel)
    {
        $applyForOrderModel->user_id = Admin::user()->id;
    }

    public function saving(ApplyForOrderModel $applyForOrderModel): void
    {
        if ($applyForOrderModel->isDirty('review_status')
            && (int)$applyForOrderModel->review_status === SaleOutOrderModel::REVIEW_STATUS_OK
        ) {
            $applyForOrderModel->items->each(function (ApplyForItemModel $applyForItemModel) use ($applyForOrderModel) {
                $applyForItemModel->batchs->each(function (ApplyForBatchModel $applyForBatchModel) use ($applyForItemModel, $applyForOrderModel) {
                    $init_num = SkuStockModel::where([
                        'sku_id' => $applyForItemModel->sku_id,
                        'percent' => $applyForItemModel->percent,
                        'standard'       => $applyForItemModel->standard,
                    ])->value('num');

                    StockHistoryModel::create([
                        'sku_id'          => $applyForItemModel->sku_id,
                        'out_position_id' => $applyForBatchModel->stock_batch->position_id,
                        'cost_price'      => $applyForBatchModel->stock_batch->cost_price,
                        'type'            => StockHistoryModel::COLLECTION_TYPE,
                        'flag'            => StockHistoryModel::OUT,
                        'with_order_no'   => $applyForOrderModel->order_no,
                        'init_num'        => $init_num,
                        'out_num'         => $applyForBatchModel->actual_num,
                        'out_price'       => $applyForBatchModel->stock_batch->cost_price,
                        'balance_num'     => $init_num - $applyForBatchModel->actual_num,
                        'percent'         => $applyForItemModel->percent,
                        'standard'        => $applyForItemModel->standard,
                        'user_id'         => Admin::user()->id,
                        'batch_no'        => $applyForBatchModel->stock_batch->batch_no,
                    ]);
                });
            });
        }
    }

    public function saved(ApplyForOrderModel $applyForOrderModel): void
    {
        if ($applyForOrderModel->with_order->status === TaskModel::STATUS_FINISH) {
            return;
        }
        $notReviewCount = ApplyForOrderModel::query()
            ->where('with_id', $applyForOrderModel->with_id)
            ->where('review_status', "!=", ApplyForOrderModel::REVIEW_STATUS_OK)->count();

        if ($notReviewCount) {
            $applyForOrderModel->with_order->status = TaskModel::STATUS_WAIT;
        } else {
            $applyForOrderModel->with_order->status = TaskModel::STATUS_DRAW;
        }
        $applyForOrderModel->with_order->saveOrFail();
    }
}
