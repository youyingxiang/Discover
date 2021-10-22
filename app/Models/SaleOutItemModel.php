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
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\SaleOutItemModel
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
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutItemModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutItemModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|SaleOutItemModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutItemModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutItemModel whereActualNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutItemModel whereBatchNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutItemModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutItemModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutItemModel whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutItemModel wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutItemModel wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutItemModel whereShouldNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutItemModel whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutItemModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SaleOutItemModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SaleOutItemModel withoutTrashed()
 * @mixin \Eloquent
 * @property string $percent 含绒量
 * @property int $standard 检验标准
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SaleOutBatchModel[] $batchs
 * @property-read int|null $batchs_count
 * @property-read int $sku_stock_num
 * @property-read mixed $standard_str
 * @property-read \App\Models\SaleOutOrderModel $order
 * @property-read \App\Models\ProductSkuModel $sku
 * @property-read \App\Models\SkuStockModel $sku_stock
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutItemModel wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutItemModel whereStandard($value)
 */
class SaleOutItemModel extends BaseModel
{
    use HasStandard;
    protected $table = 'sale_out_item';

    protected $with = ['sku'];

    protected $appends = ['sku_stock_num', 'standard_str'];

    public function sku(): BelongsTo
    {
        return $this->belongsTo(ProductSkuModel::class, 'sku_id');
    }

    public function batchs(): HasMany
    {
        return $this->hasMany(SaleOutBatchModel::class, 'item_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(SaleOutOrderModel::class, 'order_id');
    }

    public function getSkuStockNumAttribute(): int
    {
        return $this->sku_stock()->value('num') ?? 0;
    }

    /**
     * @return BelongsTo
     */
    public function sku_stock(): BelongsTo
    {
        return $this->belongsTo(SkuStockModel::class, 'sku_id', 'sku_id')
            ->where([
                'percent' => $this->percent,
                'standard' => $this->standard,
            ]);
    }
}
