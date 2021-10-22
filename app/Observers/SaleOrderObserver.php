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
use Dcat\Admin\Admin;

class SaleOrderObserver
{
    /**
     * Handle the sale order model "created" event.
     *
     * @param  \App\Models\SaleOrderModel  $saleOrderModel
     * @return void
     */
    public function created(SaleOrderModel $saleOrderModel)
    {
        //
    }

    /**
     * Handle the sale order model "updated" event.
     *
     * @param  \App\Models\SaleOrderModel  $saleOrderModel
     * @return void
     */
    public function updated(SaleOrderModel $saleOrderModel)
    {
        //
    }

    /**
     * Handle the sale order model "deleted" event.
     *
     * @param  \App\Models\SaleOrderModel  $saleOrderModel
     * @return void
     */
    public function deleted(SaleOrderModel $saleOrderModel)
    {
        //
    }

    /**
     * Handle the sale order model "restored" event.
     *
     * @param  \App\Models\SaleOrderModel  $saleOrderModel
     * @return void
     */
    public function restored(SaleOrderModel $saleOrderModel)
    {
        //
    }

    /**
     * Handle the sale order model "force deleted" event.
     *
     * @param  \App\Models\SaleOrderModel  $saleOrderModel
     * @return void
     */
    public function forceDeleted(SaleOrderModel $saleOrderModel)
    {
        //
    }

    public function creating(SaleOrderModel $saleOrderModel)
    {
        $saleOrderModel->user_id = Admin::user()->id;
    }
}
