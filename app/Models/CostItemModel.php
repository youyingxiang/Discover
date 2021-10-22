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

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CostItemModel
 *
 * @property int $id
 * @property int $order_id 订单id
 * @property int $cost_type 费用类型
 * @property int $pay_type 支付类型
 * @property string $should_amount 应付金额
 * @property string $actual_amount 实付金额
 * @property int $with_id 相关订单
 * @property string $other 备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $with_order_no
 * @property-read mixed $cost_type_str
 * @property-read \App\Models\CostOrderModel $order
 * @method static \Illuminate\Database\Eloquent\Builder|CostItemModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CostItemModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|CostItemModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CostItemModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|CostItemModel whereActualAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostItemModel whereCostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostItemModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostItemModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostItemModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostItemModel whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostItemModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostItemModel wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostItemModel whereShouldAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostItemModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostItemModel whereWithId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostItemModel whereWithOrderNo($value)
 * @method static \Illuminate\Database\Query\Builder|CostItemModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CostItemModel withoutTrashed()
 * @mixin \Eloquent
 */
class CostItemModel extends BaseModel
{
    protected $table = 'cost_item';
    protected $appends = ['cost_type_str'];

    const COST_TYPE_PURCHASE = 1;
    const COST_TYPE_SALE = 2;

    const COST_TYPE = [
        self::COST_TYPE_PURCHASE => '采购',
        self::COST_TYPE_SALE => '销售',
    ];

    public function getCostTypeStrAttribute()
    {
        return self::COST_TYPE[$this->cost_type];
    }

    public function order():BelongsTo
    {
        return $this->belongsTo(CostOrderModel::class, 'order_id');
    }
}
