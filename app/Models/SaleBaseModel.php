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
 * App\Models\SaleBaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SaleBaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleBaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleBaseModel query()
 * @mixin \Eloquent
 */
class SaleBaseModel extends BaseModel
{
    const STATUS_DOING = 0;
    const STATUS_SEND = 1;
    const STATUS_SIGN = 2;
    const STATUS_RETURNED = 3;

    const STATUS = [
        self::STATUS_DOING    => '受理中',
        self::STATUS_SEND     => '已发货',
        self::STATUS_SIGN     => '已签收',
        self::STATUS_RETURNED => '已退回',
    ];

    const STATUS_COLOR = [
        self::STATUS_DOING    => 'gray',
        self::STATUS_SEND     => 'success',
        self::STATUS_SIGN     => 'yellow',
        self::STATUS_RETURNED => 'success',
    ];
}
