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

use App\Models\PurchaseItemModel;

class PurchaseItemObserver
{
    /**
     * Handle the purchase item model "created" event.
     *
     * @param  \App\Models\PurchaseItemModel $purchaseItemModel
     * @return void
     */
    public function created(PurchaseItemModel $purchaseItemModel)
    {
        //
    }

    /**
     * Handle the purchase item model "updated" event.
     *
     * @param  \App\Models\PurchaseItemModel $purchaseItemModel
     * @return void
     */
    public function updated(PurchaseItemModel $purchaseItemModel)
    {
        //
    }

    /**
     * Handle the purchase item model "deleted" event.
     *
     * @param  \App\Models\PurchaseItemModel $purchaseItemModel
     * @return void
     */
    public function deleted(PurchaseItemModel $purchaseItemModel)
    {
        //
    }

    /**
     * Handle the purchase item model "restored" event.
     *
     * @param  \App\Models\PurchaseItemModel $purchaseItemModel
     * @return void
     */
    public function restored(PurchaseItemModel $purchaseItemModel)
    {
        //
    }

    /**
     * Handle the purchase item model "force deleted" event.
     *
     * @param  \App\Models\PurchaseItemModel $purchaseItemModel
     * @return void
     */
    public function forceDeleted(PurchaseItemModel $purchaseItemModel)
    {
        //
    }

    /**
     * @param PurchaseItemModel $purchaseItemModel
     */
    public function saving(PurchaseItemModel $purchaseItemModel)
    {
    }
}
