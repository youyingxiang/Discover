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
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ApplyForOrderModel
 *
 * @property int $id
 * @property int $with_id 关联任务id
 * @property string $order_no 单号
 * @property int $user_id 创建人
 * @property int $apply_id 审核人
 * @property string|null $other 备注
 * @property int $review_status 状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Administrator $apply_user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ApplyForItemModel[] $items
 * @property-read int|null $items_count
 * @property-read Administrator $user
 * @property-read \App\Models\TaskModel $with_order
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForOrderModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|ApplyForOrderModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForOrderModel whereApplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForOrderModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForOrderModel whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForOrderModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForOrderModel whereReviewStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForOrderModel whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForOrderModel whereWithId($value)
 * @method static \Illuminate\Database\Query\Builder|ApplyForOrderModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ApplyForOrderModel withoutTrashed()
 * @mixin \Eloquent
 */
class ApplyForOrderModel extends BaseModel
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'apply_for_order';

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(ApplyForItemModel::class, 'order_id');
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
        return $this->belongsTo(TaskModel::class, 'with_id');
    }
}
