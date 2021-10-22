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
 * App\Models\InventoryOrderModel
 *
 * @property int $id
 * @property string $order_no 单号
 * @property int $with_id 关联id
 * @property int $user_id 创建人
 * @property int $apply_id 审核人
 * @property string $other 备注
 * @property int $review_status 审核状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Administrator $apply_user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InventoryItemModel[] $items
 * @property-read int|null $items_count
 * @property-read Administrator $user
 * @property-read \App\Models\InventoryModel $with_order
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryOrderModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|InventoryOrderModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryOrderModel whereApplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryOrderModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryOrderModel whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryOrderModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryOrderModel whereReviewStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryOrderModel whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryOrderModel whereWithId($value)
 * @method static \Illuminate\Database\Query\Builder|InventoryOrderModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InventoryOrderModel withoutTrashed()
 * @mixin \Eloquent
 */
class InventoryOrderModel extends BaseModel
{
    use SoftDeletes;
    protected $table = 'inventory_order';

    public function items(): HasMany
    {
        return $this->hasMany(InventoryItemModel::class, 'order_id');
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
    public function apply_user(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'apply_id');
    }

    /**
     * @return BelongsTo
     */
    public function with_order():BelongsTo
    {
        return $this->belongsTo(InventoryModel::class, 'with_id');
    }
}
