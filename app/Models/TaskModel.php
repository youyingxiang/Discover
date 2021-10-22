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

use App\Traits\HasStandard;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\TaskModel
 *
 * @property int $id
 * @property string $order_no 任务单号
 * @property int $sku_id 商品
 * @property string $percent 含绒量
 * @property int $standard 检验标准
 * @property string $plan_num 计划数量
 * @property string $finish_num 完成数量
 * @property int $craft_id 生产工艺
 * @property int $status 状态
 * @property string|null $other 备注
 * @property int $user_id 任务创建人
 * @property int $operator 操作人员
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $product_id 商品id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ApplyForOrderModel[] $apply_orders
 * @property-read int|null $apply_orders_count
 * @property-read \App\Models\CraftModel $craft
 * @property-read mixed $standard_str
 * @property-read string $status_str
 * @property-read float $sum_cost_price
 * @property-read \App\Models\MakeProductOrderModel|null $make_product_order
 * @property-read Administrator $operator_user
 * @property-read \App\Models\ProductSkuModel $sku
 * @property-read Administrator $user
 * @method static Builder|TaskModel newModelQuery()
 * @method static Builder|TaskModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|TaskModel onlyTrashed()
 * @method static Builder|TaskModel query()
 * @method static Builder|TaskModel whereCraftId($value)
 * @method static Builder|TaskModel whereCreatedAt($value)
 * @method static Builder|TaskModel whereDeletedAt($value)
 * @method static Builder|TaskModel whereFinishNum($value)
 * @method static Builder|TaskModel whereId($value)
 * @method static Builder|TaskModel whereOperator($value)
 * @method static Builder|TaskModel whereOrderNo($value)
 * @method static Builder|TaskModel whereOther($value)
 * @method static Builder|TaskModel wherePercent($value)
 * @method static Builder|TaskModel wherePlanNum($value)
 * @method static Builder|TaskModel whereProductId($value)
 * @method static Builder|TaskModel whereSkuId($value)
 * @method static Builder|TaskModel whereStandard($value)
 * @method static Builder|TaskModel whereStatus($value)
 * @method static Builder|TaskModel whereUpdatedAt($value)
 * @method static Builder|TaskModel whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|TaskModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TaskModel withoutTrashed()
 * @mixin \Eloquent
 */
class TaskModel extends BaseModel
{
    use HasDateTimeFormatter;
    use SoftDeletes;
    use HasStandard;

    const STATUS_WAIT = 0;
    const STATUS_DRAW = 1;
    const STATUS_FINISH = 2;
    const STATUS_STOP = 3;
    const STATUS = [
        self::STATUS_WAIT   => "待领料",
        self::STATUS_DRAW   => "已领料",
        self::STATUS_FINISH => "已完成",
        self::STATUS_STOP   => "停止",
    ];

    const STATUS_COLOR = [
        self::STATUS_WAIT      => 'gray',
        self::STATUS_DRAW    => 'yellow',
        self::STATUS_FINISH => 'success',
    ];

    protected $table = 'task';

    protected $appends = ['standard_str', 'status_str', 'sum_cost_price'];

    public function sku(): BelongsTo
    {
        return $this->belongsTo(ProductSkuModel::class, 'sku_id');
    }

    /**
     * @param $key
     * @return string
     */
    public function getStatusStrAttribute():string
    {
        return self::STATUS[$this->status];
    }

    public function craft()
    {
        return $this->belongsTo(CraftModel::class);
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
    public function operator_user(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'operator');
    }

    /**
     * @return HasMany
     */
    public function apply_orders():HasMany
    {
        return $this->hasMany(ApplyForOrderModel::class, 'with_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function make_product_order():HasOne
    {
        return $this->hasOne(MakeProductOrderModel::class, 'with_id');
    }

    /**
     * @return float
     */
    public function getSumCostPriceAttribute():float
    {
        return ApplyForItemModel::query()->whereHas('order', function (Builder $builder) {
            $builder->where('review_status', ApplyForOrderModel::REVIEW_STATUS_OK);
            $builder->where('with_id', $this->id);
        })->sum('cost_price');
    }
}
