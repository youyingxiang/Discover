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

use App\Models\CheckProductModel;
use App\Models\SkuStockBatchModel;
use App\Models\SkuStockModel;
use App\Models\StockHistoryModel;
use Dcat\Admin\Admin;

class CheckProductObserver
{
    public function creating(CheckProductModel $checkProductModel):void
    {
        $prevSkuStockBatchModel = SkuStockBatchModel::query()->findOrFail($checkProductModel->prev_sku_stock_batch_id);
        $prevStockNum = SkuStockModel::query()
            ->where([
                'sku_id' => $prevSkuStockBatchModel->sku_id,
                'percent' => $prevSkuStockBatchModel->percent,
                'standard'       => $prevSkuStockBatchModel->standard,
            ])->value('num');
        $this->checkBeforeOldProductStock($checkProductModel, $prevSkuStockBatchModel, $prevStockNum);

        $newBatchStockNum = SkuStockBatchModel::query()->firstOrCreate([
            'sku_id' => $prevSkuStockBatchModel->sku_id,
            'percent' => $checkProductModel->percent,
            'standard'       => $checkProductModel->standard,
            'position_id' => $prevSkuStockBatchModel->position_id,
            'batch_no'    => $prevSkuStockBatchModel->batch_no,
        ], [
            'num' => 0,
        ]);

        $this->checkAfterNewProductStock(
            $checkProductModel,
            $prevSkuStockBatchModel,
            $newBatchStockNum
        );
        $checkProductModel->sku_stock_batch_id = $newBatchStockNum->id;
    }

    private function checkAfterNewProductStock(
        CheckProductModel $checkProductModel,
        SkuStockBatchModel $prevSkuStockBatchModel,
        SkuStockBatchModel $newBatchStockNum
    ) {
        StockHistoryModel::query()->create([
            'sku_id'          => $prevSkuStockBatchModel->sku_id,
            'in_position_id' => $prevSkuStockBatchModel->position_id,
            'cost_price'      => $prevSkuStockBatchModel->cost_price,
            'type'            => StockHistoryModel::CHECK_IN_TYPE,
            'flag'            => StockHistoryModel::IN,
            'with_order_no'   => $checkProductModel->order_no,
            'init_num'        => $newBatchStockNum->num,
            'in_num'          => $prevSkuStockBatchModel->num,
            'in_price'        => $prevSkuStockBatchModel->cost_price,
            'balance_num'     => $prevSkuStockBatchModel->num + $newBatchStockNum->num,
            'standard'        => $checkProductModel->standard,
            'user_id'         => Admin::user()->id,
            'percent'         => $checkProductModel->percent,
            'batch_no'        => $prevSkuStockBatchModel->batch_no,
        ]);
    }

    public function checkBeforeOldProductStock(
        CheckProductModel $checkProductModel,
        SkuStockBatchModel $prevSkuStockBatchModel,
        int $prevStockNum
    ) {
        StockHistoryModel::query()->create([
            'sku_id'          => $prevSkuStockBatchModel->sku_id,
            'out_position_id' => $prevSkuStockBatchModel->position_id,
            'cost_price'      => $prevSkuStockBatchModel->cost_price,
            'type'            => StockHistoryModel::CHECK_OUT_TYPE,
            'flag'            => StockHistoryModel::OUT,
            'with_order_no'   => $checkProductModel->order_no,
            'init_num'        => $prevStockNum,
            'out_num'         => $prevSkuStockBatchModel->num,
            'out_price'       => $prevSkuStockBatchModel->cost_price,
            'balance_num'     => $prevStockNum - $prevSkuStockBatchModel->num,
            'percent'         => $prevSkuStockBatchModel->percent,
            'standard'        => $prevSkuStockBatchModel->standard,
            'user_id'         => Admin::user()->id,
            'batch_no'        => $prevSkuStockBatchModel->batch_no,
        ]);
    }
}
