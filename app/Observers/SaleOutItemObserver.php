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

class SaleOutItemObserver
{
    /**
     * Handle the sale out item model "created" event.
     *
     * @param  \App\Models\SaleOutItemModel $saleOutItemModel
     * @return void
     */
    public function created(SaleOutItemModel $saleOutItemModel): void
    {
        //
    }

    /**
     * Handle the sale out item model "updated" event.
     *
     * @param  \App\Models\SaleOutItemModel $saleOutItemModel
     * @return void
     */
    public function updated(SaleOutItemModel $saleOutItemModel): void
    {
        //
    }

    /**
     * Handle the sale out item model "deleted" event.
     *
     * @param  \App\Models\SaleOutItemModel $saleOutItemModel
     * @return void
     */
    public function deleted(SaleOutItemModel $saleOutItemModel): void
    {
        SaleOutBatchModel::where(function (Builder $query) use ($saleOutItemModel) {
            $query->where("item_id", $saleOutItemModel->id);
        })->delete();
    }

    /**
     * Handle the sale out item model "restored" event.
     *
     * @param  \App\Models\SaleOutItemModel $saleOutItemModel
     * @return void
     */
    public function restored(SaleOutItemModel $saleOutItemModel): void
    {
        //
    }

    /**
     * Handle the sale out item model "force deleted" event.
     *
     * @param  \App\Models\SaleOutItemModel $saleOutItemModel
     * @return void
     */
    public function forceDeleted(SaleOutItemModel $saleOutItemModel): void
    {
        //
    }

    public function saving(SaleOutItemModel $saleOutItemModel): void
    {
        if ($saleOutItemModel->isDirty(['percent', 'price', 'standard'])) {
            SaleOutBatchModel::where(function (Builder $query) use ($saleOutItemModel) {
                $query->where("item_id", $saleOutItemModel->id);
            })->delete();
            $saleOutItemModel->actual_num = 0;
        }
    }
}
