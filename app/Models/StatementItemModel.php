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
 * App\Models\StatementItemModel
 *
 * @property int $id
 * @property string $order_id
 * @property string $statement_order_id
 * @property string $order_amount
 * @property string $should_amount
 * @property string $actual_amount
 * @property string $discount_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StatementItemModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatementItemModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatementItemModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatementItemModel whereActualAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementItemModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementItemModel whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementItemModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementItemModel whereOrderAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementItemModel whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementItemModel whereShouldAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementItemModel whereStatementOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementItemModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StatementItemModel extends BaseModel
{
    protected $table = 'statement_item';

    protected $appends = ['remaining_sum'];

    /**
     * @return BelongsTo
     */
    public function cost_order():BelongsTo
    {
        return $this->belongsTo(CostOrderModel::class, 'statement_order_id');
    }

    public function order():BelongsTo
    {
        return $this->belongsTo(StatementOrderModel::class, 'order_id');
    }

    /**
     * @return float
     */
    public function getRemainingSumAttribute():float
    {
        $res = bcsub($this->should_amount, bcadd($this->actual_amount, $this->discount_amount, 5), 2);
        return $res > 0 ? $res : 0;
    }
}
