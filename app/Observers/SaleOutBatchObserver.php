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

use App\Models\SaleOutBatchModel;
use App\Models\SaleOutItemModel;
use Illuminate\Database\Eloquent\Builder;

class SaleOutBatchObserver
{
    /**
     * Handle the sale out batch model "created" event.
     *
     * @param  \App\Models\SaleOutBatchModel $saleOutBatchModel
     * @return void
     */
    public function created(SaleOutBatchModel $saleOutBatchModel): void
    {
        //
    }

    /**
     * Handle the sale out batch model "updated" event.
     *
     * @param  \App\Models\SaleOutBatchModel $saleOutBatchModel
     * @return void
     */
    public function updated(SaleOutBatchModel $saleOutBatchModel): void
    {
        //
    }

    /**
     * Handle the sale out batch model "deleted" event.
     *
     * @param  \App\Models\SaleOutBatchModel $saleOutBatchModel
     * @return void
     */
    public function deleted(SaleOutBatchModel $saleOutBatchModel): void
    {
        $this->updateItemActual($saleOutBatchModel);
    }

    /**
     * Handle the sale out batch model "restored" event.
     *
     * @param  \App\Models\SaleOutBatchModel $saleOutBatchModel
     * @return void
     */
    public function restored(SaleOutBatchModel $saleOutBatchModel): void
    {
        //
    }

    /**
     * Handle the sale out batch model "force deleted" event.
     *
     * @param  \App\Models\SaleOutBatchModel $saleOutBatchModel
     * @return void
     */
    public function forceDeleted(SaleOutBatchModel $saleOutBatchModel): void
    {
        //
    }

    public function saved(SaleOutBatchModel $saleOutBatchModel): void
    {
        $this->updateItemActual($saleOutBatchModel);
    }

    /**
     * @param SaleOutBatchModel $saleOutBatchModel
     */
    protected function updateItemActual(SaleOutBatchModel $saleOutBatchModel): void
    {
        $saleBatchs = SaleOutBatchModel::where(function (Builder $query) use ($saleOutBatchModel) {
            $query->where("item_id", $saleOutBatchModel->item_id);
        })->get();

        $sumCostPrice = $saleBatchs->reduce(function (float $sumCostPrice, SaleOutBatchModel $batchModel) {
            return bcadd($sumCostPrice, bcmul($batchModel->cost_price, $batchModel->actual_num, 5), 2);
        }, 0);

        SaleOutItemModel::whereId($saleOutBatchModel->item_id)->update([
            "actual_num" => $saleBatchs->sum('actual_num'),
            "sum_cost_price" => $sumCostPrice
        ]);
    }
}
