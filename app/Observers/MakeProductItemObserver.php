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

use App\Models\MakeProductItemModel;

class MakeProductItemObserver
{
    public function saving(MakeProductItemModel $makeProductItemModel): void
    {
        if ($makeProductItemModel->isDirty('actual_num')) {
            $task = $makeProductItemModel->order->with_order;
            $avgCostPrice = bcdiv($task->sum_cost_price, $makeProductItemModel->actual_num, 2);
            $makeProductItemModel->cost_price = $avgCostPrice;
        }
    }
}
