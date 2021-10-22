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
 * App\Models\PurchaseOrderModel
 *
 * @property int $id
 * @property string $order_no 订单单号
 * @property int $supplier_id 供应商id
 * @property int $status 状态
 * @property string $other 备注
 * @property int $check_status 检测状态
 * @property int $user_id 创建订单用户
 * @property string|null $finished_at 订单完成时间
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|PurchaseOrderModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderModel whereCheckStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderModel whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderModel whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderModel whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderModel whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|PurchaseOrderModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PurchaseOrderModel withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PurchaseItemModel[] $items
 * @property-read int|null $items_count
 * @property int $review_status 审核状态
 * @property-read \App\Models\SupplierModel $supplier
 * @property-read Administrator $user
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderModel whereReviewStatus($value)
 * @property-read string $status_str
 * @property-read string $supplier_str
 */
class PurchaseOrderModel extends PurchaseBaseModel
{
    use SoftDeletes;
    protected $table = 'purchase_order';

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItemModel::class, 'order_id');
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
}
