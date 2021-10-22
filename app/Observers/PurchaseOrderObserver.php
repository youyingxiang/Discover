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

use App\Models\PurchaseOrderModel;
use Dcat\Admin\Admin;

class PurchaseOrderObserver
{
    /**
     * Handle the purchase order model "created" event.
     *
     * @param  \App\Models\PurchaseOrderModel  $purchaseOrderModel
     * @return void
     */
    public function created(PurchaseOrderModel $purchaseOrderModel)
    {
        //
    }

    /**
     * Handle the purchase order model "updated" event.
     *
     * @param  \App\Models\PurchaseOrderModel  $purchaseOrderModel
     * @return void
     */
    public function updated(PurchaseOrderModel $purchaseOrderModel)
    {
        //
    }

    /**
     * Handle the purchase order model "deleted" event.
     *
     * @param  \App\Models\PurchaseOrderModel  $purchaseOrderModel
     * @return void
     */
    public function deleted(PurchaseOrderModel $purchaseOrderModel)
    {
        //
    }

    /**
     * Handle the purchase order model "restored" event.
     *
     * @param  \App\Models\PurchaseOrderModel  $purchaseOrderModel
     * @return void
     */
    public function restored(PurchaseOrderModel $purchaseOrderModel)
    {
        //
    }

    /**
     * Handle the purchase order model "force deleted" event.
     *
     * @param  \App\Models\PurchaseOrderModel  $purchaseOrderModel
     * @return void
     */
    public function forceDeleted(PurchaseOrderModel $purchaseOrderModel)
    {
        //
    }

    /**
     * @param PurchaseOrderModel $purchaseOrderModel
     */
    public function saving(PurchaseOrderModel $purchaseOrderModel)
    {
    }

    /**
     * @param PurchaseOrderModel $purchaseOrderModel
     */
    public function creating(PurchaseOrderModel $purchaseOrderModel)
    {
        $purchaseOrderModel->user_id = Admin::user()->id;
    }
}
