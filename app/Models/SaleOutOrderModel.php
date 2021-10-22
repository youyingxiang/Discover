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
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\SaleOutOrderModel
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
 * @property int $with_id 相关单据id
 * @property int $review_status 审核状态
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|SaleOutOrderModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel whereReviewStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel whereWithId($value)
 * @method static \Illuminate\Database\Query\Builder|SaleOutOrderModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SaleOutOrderModel withoutTrashed()
 * @mixin \Eloquent
 * @property int $address_id 客户地址
 * @property int $drawee_id 付款人
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel whereDraweeId($value)
 * @property string|null $apply_at
 * @property-read \App\Models\CustomerAddressModel $address
 * @property-read \App\Models\SaleOrderAmountModel|null $amount
 * @property-read \App\Models\CustomerModel $customer
 * @property-read \App\Models\DraweeModel $drawee
 * @property-read string $status_str
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SaleOutItemModel[] $items
 * @property-read int|null $items_count
 * @property-read Administrator $user
 * @property-read \App\Models\SaleOrderModel $with_order
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutOrderModel whereApplyAt($value)
 */
class SaleOutOrderModel extends SaleBaseModel
{
    use SoftDeletes;

    protected $table = 'sale_out_order';

    /**
     * @return BelongsTo
     */
    public function with_order():BelongsTo
    {
        return $this->belongsTo(SaleOrderModel::class, 'with_id');
    }

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(SaleOutItemModel::class, 'order_id');
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

    public function amount(): HasOne
    {
        return $this->hasOne(SaleOrderAmountModel::class, 'order_id');
    }

    /**
     * @return string
     */
    public function getStatusStrAttribute():string
    {
        return self::STATUS[$this->status];
    }
}
