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
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\SaleOrderAmountModel
 *
 * @property int $id
 * @property int $order_id 订单id
 * @property int $customer_id 客户id
 * @property int $status 结算状态
 * @property string $should_amount 费用金额
 * @property string $actual_amount 结算金额
 * @property int $accountant_id 结算年月
 * @property string|null $settlement_at 结算日期
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\AccountantDateModel $accountant
 * @property-read \App\Models\CustomerModel $customer
 * @property-read \App\Models\SaleOutOrderModel $order
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderAmountModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderAmountModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|SaleOrderAmountModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderAmountModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderAmountModel whereAccountantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderAmountModel whereActualAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderAmountModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderAmountModel whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderAmountModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderAmountModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderAmountModel whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderAmountModel whereSettlementAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderAmountModel whereShouldAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderAmountModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOrderAmountModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SaleOrderAmountModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SaleOrderAmountModel withoutTrashed()
 * @mixin \Eloquent
 */
class SaleOrderAmountModel extends BaseModel
{
    use SoftDeletes;

    protected $table = 'sale_order_amount';

    const STATUS = [
        self::STATUS_NO => '未月结',
        self::STATUS_OK => '已月结'
    ];
    const STATUS_COLOR = [
        self::STATUS_NO => "red",
        self::STATUS_OK => "success",
    ];

    public function order():BelongsTo
    {
        return $this->belongsTo(SaleOutOrderModel::class, 'order_id');
    }

    public function customer():BelongsTo
    {
        return $this->belongsTo(CustomerModel::class, 'customer_id');
    }

    public function accountant():BelongsTo
    {
        return $this->belongsTo(AccountantDateModel::class, 'accountant_id');
    }
}
