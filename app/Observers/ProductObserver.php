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

use App\Models\ProductModel;
use Dcat\Admin\Admin;

class ProductObserver
{
    /**
     * Handle the product model "created" event.
     *
     * @param  \App\Models\ProductModel $productModel
     * @return void
     */
    public function created(ProductModel $productModel)
    {
        //
    }

    /**
     * Handle the product model "updated" event.
     *
     * @param  \App\Models\ProductModel $productModel
     * @return void
     */
    public function updated(ProductModel $productModel)
    {
        //
    }

    /**
     * Handle the product model "deleted" event.
     *
     * @param  \App\Models\ProductModel $productModel
     * @return void
     */
    public function deleted(ProductModel $productModel)
    {
        //
    }

    /**
     * Handle the product model "restored" event.
     *
     * @param  \App\Models\ProductModel $productModel
     * @return void
     */
    public function restored(ProductModel $productModel)
    {
        //
    }

    /**
     * Handle the product model "force deleted" event.
     *
     * @param  \App\Models\ProductModel $productModel
     * @return void
     */
    public function forceDeleted(ProductModel $productModel)
    {
        //
    }

    /**
     * @param ProductModel $productModel
     */
    public function saving(ProductModel $productModel): void
    {
        // 拼音码
        $productModel->name && $productModel->py_code = up_pinyin_abbr($productModel->name);
    }

    /**
     * @param ProductModel $productModel
     */
    public function saved(ProductModel $productModel): void
    {
    }

    /**
     * @param ProductModel $productModel
     */
    public function creating(ProductModel $productModel): void
    {
//        $productModel->create_user_id = Admin::user()->id;
    }
}
