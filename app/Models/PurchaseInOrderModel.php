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
 * App\Models\PurchaseInOrderModel
 *
 * @property int $id
 * @property string $order_no 订单单号
 * @property int $supplier_id 供应商id
 * @property int $status 状态
 * @property string $other 备注
 * @property int $user_id 创建订单用户
 * @property string|null $finished_at 订单完成时间
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $with_id 相关单据id
 * @property int $review_status 审核状态
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PurchaseInItemModel[] $items
 * @property-read int|null $items_count
 * @property-read \App\Models\SupplierModel $supplier
 * @property-read Administrator $user
 * @property-read \App\Models\PurchaseOrderModel $with_order
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|PurchaseInOrderModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel whereReviewStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel whereWithId($value)
 * @method static \Illuminate\Database\Query\Builder|PurchaseInOrderModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PurchaseInOrderModel withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $apply_at
 * @property-read \App\Models\PurchaseOrderAmountModel|null $amount
 * @property-read string $status_str
 * @property-read string $supplier_str
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInOrderModel whereApplyAt($value)
 */
class PurchaseInOrderModel extends PurchaseBaseModel
{
    use SoftDeletes;

    protected $table = 'purchase_in_order';

    /**
     * @return BelongsTo
     */
    public function with_order():BelongsTo
    {
        return $this->belongsTo(PurchaseOrderModel::class, 'with_id');
    }

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseInItemModel::class, 'order_id');
    }

    /**
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'user_id');
    }

    /**
     * @return string
     */
    public function getStatusStrAttribute():string
    {
        return self::STATUS[$this->status];
    }

    /**
     * @return string
     */
    public function getSupplierStrAttribute():string
    {
        return $this->supplier->name;
    }

    /**
     * @return HasOne
     */
    public function amount(): HasOne
    {
        return $this->hasOne(PurchaseOrderAmountModel::class, 'order_id');
    }
}
