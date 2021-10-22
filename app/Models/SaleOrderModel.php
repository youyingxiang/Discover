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

use Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\SaleOrderModel
 *
 * @property int $id
 * @property string $order_no 订单单号
 * @property int $customer_id 客户档案
 * @property int $status 状态
 * @property string $other 备注
 * @property int $user_id 创建订单用户
 * @property string|null $finished_at 订单完成时间
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $review_status 审核状态
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|SaleOrderModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel whereReviewStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|SaleOrderModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SaleOrderModel withoutTrashed()
 * @mixin \Eloquent
 * @property int $address_id 客户地址
 * @property int $drawee_id 付款人
 * @property-read \App\Models\CustomerModel $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SaleItemModel[] $items
 * @property-read int|null $items_count
 * @property-read Administrator $user
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderModel whereDraweeId($value)
 * @property-read \App\Models\CustomerAddressModel $address
 * @property-read \App\Models\DraweeModel $drawee
 * @property-read string $status_str
 */
class SaleOrderModel extends SaleBaseModel
{
    use SoftDeletes;

    protected $table = 'sale_order';

    /**
     * @return HasMany
     */
    public function items():HasMany
    {
        return $this->hasMany(SaleItemModel::class, 'order_id');
    }

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(CustomerModel::class, 'customer_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(CustomerAddressModel::class, 'address_id');
    }

    /**
     * @return BelongsTo
     */
    public function drawee(): BelongsTo
    {
        return $this->belongsTo(DraweeModel::class, 'drawee_id');
    }

    /**
     * @return string
     */
    public function getStatusStrAttribute():string
    {
        return self::STATUS[$this->status];
    }
}
