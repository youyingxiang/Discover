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
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PurchaseInItemModel
 *
 * @property int $id
 * @property int $order_id 订单id
 * @property int $sku_id 采购商品的skuid
 * @property int $should_num 采购数量
 * @property int $actual_num 入库数量
 * @property string $price 价格
 * @property int $position_id 位置id
 * @property string $batch_no 批次号
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductSkuModel $sku
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInItemModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInItemModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInItemModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInItemModel whereActualNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInItemModel whereBatchNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInItemModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInItemModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInItemModel whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInItemModel wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInItemModel wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInItemModel whereShouldNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInItemModel whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInItemModel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $percent 含绒量
 * @property int $standard 检验标准
 * @property-read mixed $standard_str
 * @property-read \App\Models\PositionModel $position
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInItemModel wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseInItemModel whereStandard($value)
 */
class PurchaseInItemModel extends BaseModel
{
    use HasStandard;

    protected $table = 'purchase_in_item';

    protected $with = ['sku'];

    protected $appends = ['standard_str'];

    public function sku(): BelongsTo
    {
        return $this->belongsTo(ProductSkuModel::class, 'sku_id');
    }

    public function position():BelongsTo
    {
        return $this->belongsTo(PositionModel::class, 'position_id');
    }

    public function order():BelongsTo
    {
        return $this->belongsTo(PurchaseInOrderModel::class, 'order_id');
    }
}
