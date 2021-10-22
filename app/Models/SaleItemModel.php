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
 * App\Models\SaleItemModel
 *
 * @property int $id
 * @property int $order_id 订单id
 * @property int $sku_id 商品的skuid
 * @property int $should_num 销售数量
 * @property int $actual_num 出库数量
 * @property string $price 价格
 * @property int $position_id 位置id
 * @property string $batch_no 批次号
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItemModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItemModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItemModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItemModel whereActualNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItemModel whereBatchNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItemModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItemModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItemModel whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItemModel wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItemModel wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItemModel whereShouldNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItemModel whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItemModel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\ProductSkuModel $sku
 * @property string $percent 含绒量
 * @property int $standard 检验标准
 * @property-read mixed $standard_str
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItemModel wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItemModel whereStandard($value)
 */
class SaleItemModel extends BaseModel
{
    use HasStandard;
    protected $table = 'sale_item';

    protected $with = ['sku'];

    public function sku(): BelongsTo
    {
        return $this->belongsTo(ProductSkuModel::class, 'sku_id');
    }
}
