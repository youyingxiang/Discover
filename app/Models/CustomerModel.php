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

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CustomerModel
 *
 * @property int $id
 * @property string $name 属性名称
 * @property string $link 联系人
 * @property int $pay_method 支付方式
 * @property string $phone 手机号码
 * @property string $other 备注
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CustomerAddressModel[] $address
 * @property-read int|null $address_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DraweeModel[] $drawee
 * @property-read int|null $drawee_count
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|CustomerModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerModel whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerModel wherePayMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerModel wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CustomerModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CustomerModel withoutTrashed()
 * @mixin \Eloquent
 */
class CustomerModel extends BaseModel
{
    use SoftDeletes;

    protected $table = 'customer';

    const PAY_CASH = 0;
    const PAY_WECHAT = 1;
    const PAY_ZFB = 2;

    const PAY = [
        self::PAY_CASH   => '现金',
        self::PAY_WECHAT => '微信',
        self::PAY_ZFB    => '支付宝',
    ];

    /**
     * @return BelongsToMany
     */
    public function drawee(): BelongsToMany
    {
        return $this->belongsToMany(DraweeModel::class, CustomerDraweeModel::class, 'customer_id', 'drawee_id');
    }

    /**
     * @return HasMany
     */
    public function address(): HasMany
    {
        return $this->hasMany(CustomerAddressModel::class, 'customer_id');
    }
}
