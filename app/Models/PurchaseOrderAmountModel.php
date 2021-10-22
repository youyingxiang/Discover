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
 * App\Models\PurchaseOrderAmountModel
 *
 * @property int $id
 * @property int $order_id 订单id
 * @property int $supplier_id 供应商id
 * @property int $status 结算状态
 * @property string $should_amount 费用金额
 * @property string $actual_amount 结算金额
 * @property int $accountant_id 结算年月
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $settlement_at
 * @property-read \App\Models\AccountantDateModel $accountant
 * @property-read \App\Models\PurchaseInOrderModel $order
 * @property-read \App\Models\SupplierModel $supplier
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderAmountModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderAmountModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderAmountModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderAmountModel whereAccountantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderAmountModel whereActualAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderAmountModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderAmountModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderAmountModel whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderAmountModel whereSettlementAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderAmountModel whereShouldAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderAmountModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderAmountModel whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderAmountModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PurchaseOrderAmountModel extends BaseModel
{
    const STATUS = [
        self::STATUS_NO => '未月结',
        self::STATUS_OK => '已月结'
    ];
    const STATUS_COLOR = [
        self::STATUS_NO => "red",
        self::STATUS_OK => "success",
    ];
    protected $table = 'purchase_order_amount';

    public function order():BelongsTo
    {
        return $this->belongsTo(PurchaseInOrderModel::class, 'order_id');
    }

    public function supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id');
    }

    public function accountant():BelongsTo
    {
        return $this->belongsTo(AccountantDateModel::class, 'accountant_id');
    }
}
