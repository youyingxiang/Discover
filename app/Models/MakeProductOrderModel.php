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
 * App\Models\MakeProductOrderModel
 *
 * @property int $id
 * @property int $with_id 相关单据id
 * @property string $order_no 单号
 * @property int $user_id 创建人
 * @property int $apply_id 审核人
 * @property string $other 备注
 * @property int $review_status 状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Administrator $apply_user
 * @property-read \App\Models\MakeProductItemModel|null $items
 * @property-read Administrator $user
 * @property-read \App\Models\TaskModel $with_order
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductOrderModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|MakeProductOrderModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductOrderModel whereApplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductOrderModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductOrderModel whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductOrderModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductOrderModel whereReviewStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductOrderModel whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductOrderModel whereWithId($value)
 * @method static \Illuminate\Database\Query\Builder|MakeProductOrderModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MakeProductOrderModel withoutTrashed()
 * @mixin \Eloquent
 */
class MakeProductOrderModel extends BaseModel
{
    use SoftDeletes;

    protected $table = 'make_product_order';

    /**
     * @return BelongsTo
     */
    public function with_order():BelongsTo
    {
        return $this->belongsTo(TaskModel::class, 'with_id');
    }

    /**
     * @return HasMany
     */
    public function items(): HasOne
    {
        return $this->hasOne(MakeProductItemModel::class, 'order_id');
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
