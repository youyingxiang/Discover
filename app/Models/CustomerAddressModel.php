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
 * App\Models\CustomerAddressModel
 *
 * @property int $id
 * @property int $customer_id 客户档案id
 * @property string $address 地址
 * @property string $other 备注
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddressModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddressModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|CustomerAddressModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddressModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddressModel whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddressModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddressModel whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddressModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddressModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddressModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddressModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CustomerAddressModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CustomerAddressModel withoutTrashed()
 * @mixin \Eloquent
 */
class CustomerAddressModel extends BaseModel
{
    use SoftDeletes;

    protected $table = 'customer_address';
}
