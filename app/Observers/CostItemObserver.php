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

use App\Models\CostItemModel;

class CostItemObserver
{
    public function saved(CostItemModel $costItemModel)
    {
        if ($costItemModel->isDirty('actual_amount')) {
            $order = $costItemModel->order;
            $order->total_amount = $order->items->sum('actual_amount');
            $order->saveOrFail();
        }
    }
}
