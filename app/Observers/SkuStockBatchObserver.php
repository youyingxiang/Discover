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

use App\Models\SkuStockBatchModel;
use App\Models\SkuStockModel;

class SkuStockBatchObserver
{
    /**
     * @param SkuStockBatchModel $skuStockBatchModel
     */
    public function saved(SkuStockBatchModel $skuStockBatchModel): void
    {
        $num = SkuStockBatchModel::query()->where([
            'sku_id' => $skuStockBatchModel->sku_id,
            'percent' => $skuStockBatchModel->percent,
            'standard'       => $skuStockBatchModel->standard,
        ])->sum('num');
        SkuStockModel::updateOrCreate(
            [
                'sku_id' => $skuStockBatchModel->sku_id,
                'percent' => $skuStockBatchModel->percent,
                'standard'       => $skuStockBatchModel->standard,
            ],
            ['num' => $num]
        );
    }
}
