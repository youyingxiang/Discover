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

namespace App\Models;

/**
 * App\Models\PurchaseBaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseBaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseBaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseBaseModel query()
 * @mixin \Eloquent
 */
class PurchaseBaseModel extends BaseModel
{
    const STATUS_WAIT = 0;
    const STATUS_ARRIVE = 1;
//    const STATUS_FINISH = 2;
    const STATUS_RETURNING = 3;
    const STATUS_RETURNED = 4;

    const CHECK_STATUS_NO = 0;
    const CHECK_STATUS_FIRST = 1;
    const CHECK_STATUS_SECOND = 2;

    const CHECK_STATUS = [
        self::CHECK_STATUS_NO     => '未检测',
        self::CHECK_STATUS_FIRST  => '完成第一次检测',
        self::CHECK_STATUS_SECOND => '完成第二次检测'
    ];

    const STATUS = [
        self::STATUS_WAIT      => '待收货',
        self::STATUS_ARRIVE    => '已收货',
        //        self::STATUS_FINISH    => '已完成',
        self::STATUS_RETURNING => '退回中',
        self::STATUS_RETURNED  => '已退回',
    ];

    const STATUS_COLOR = [
        self::STATUS_WAIT      => 'gray',
        self::STATUS_ARRIVE    => 'success',
        //        self::STATUS_FINISH    => 'success',
        self::STATUS_RETURNING => 'yellow',
        self::STATUS_RETURNED  => 'success',
    ];
}
