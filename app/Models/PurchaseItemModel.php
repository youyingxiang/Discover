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
 * App\Models\PurchaseItemModel
 *
 * @property int $id
 * @property int $order_id 订单id
 * @property int $sku_id 采购商品的skuid
 * @property int $should_num 采购数量
 * @property int $actual_num 入库数量
 * @property string $price 价格
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItemModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItemModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItemModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItemModel whereActualNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItemModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItemModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItemModel whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItemModel wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItemModel whereShouldNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItemModel whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItemModel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\ProductSkuModel $sku
 * @property string $percent 含绒量
 * @property int $standard 检验标准
 * @property-read mixed $standard_str
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItemModel wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItemModel whereStandard($value)
 */
class PurchaseItemModel extends BaseModel
{
    use HasStandard;
    protected $table = 'purchase_item';

    protected $with = ['sku'];

    public function sku(): BelongsTo
    {
        return $this->belongsTo(ProductSkuModel::class, 'sku_id');
    }
}
