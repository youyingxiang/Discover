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
 * App\Models\InitStockOrderModel
 *
 * @property int $id
 * @property string $order_no 单号
 * @property int $user_id 创建人
 * @property int $apply_id 审核人
 * @property string|null $other 备注
 * @property int $review_status 状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Administrator $apply_user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InitStockItemModel[] $items
 * @property-read int|null $items_count
 * @property-read Administrator $user
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockOrderModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|InitStockOrderModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockOrderModel whereApplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockOrderModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockOrderModel whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockOrderModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockOrderModel whereReviewStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockOrderModel whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|InitStockOrderModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InitStockOrderModel withoutTrashed()
 * @mixin \Eloquent
 */
class InitStockOrderModel extends BaseModel
{
    use SoftDeletes;

    protected $table = 'init_stock_order';

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(InitStockItemModel::class, 'order_id');
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
}
