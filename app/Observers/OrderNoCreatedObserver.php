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

use App\Models\OrderNoGeneratorModel;
use Illuminate\Database\Eloquent\Model;

class OrderNoCreatedObserver
{
    public function creating(Model $model)
    {
        $orderNo = $model->order_no;
        $str = mb_substr($orderNo, 0, mb_strlen($orderNo) - 4);
        $prefix = mb_substr($str, 0, mb_strlen($str) - 8);
        $happenDate = mb_substr($str, mb_strlen($str) - 8);
        $orderNoGenerator = OrderNoGeneratorModel::query()
            ->firstOrCreate(
                [
                    'prefix' => $prefix,
                    'happen_date' => $happenDate,
                ],
                [
                    'number' => 0
                ]
            );
        $orderNoGenerator->increment('number');
    }
}
