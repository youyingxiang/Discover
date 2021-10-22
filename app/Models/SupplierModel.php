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

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\SupplierModel
 *
 * @property int $id
 * @property string $name 供应商名称
 * @property string $link 联系人
 * @property int $pay_method 结算方式
 * @property string $phone 手机号
 * @property string $other 备注
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|SupplierModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierModel whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierModel wherePayMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierModel wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SupplierModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SupplierModel withoutTrashed()
 * @mixin \Eloquent
 */
class SupplierModel extends BaseModel
{
    use SoftDeletes;

    protected $table = 'supplier';

    const PAY_METHOD_CASH = 0;
    const PAY_METHOD_ZFB = 1;
    const PAY_METHOD_WECHAT = 2;

    const PAY_METHOD = [
        self::PAY_METHOD_CASH   => '现金',
        self::PAY_METHOD_ZFB    => '支付宝',
        self::PAY_METHOD_WECHAT => '微信',
    ];
}
