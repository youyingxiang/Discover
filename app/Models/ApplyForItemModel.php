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
 * App\Models\ApplyForItemModel
 *
 * @property int $id
 * @property int $order_id 关联单据
 * @property int $sku_id 商品的skuId
 * @property string $cost_price 成本价格
 * @property int $standard 检验标准
 * @property string $percent 含绒量
 * @property string $should_num 申领数量
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $actual_num 实领数量
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ApplyForBatchModel[] $batchs
 * @property-read int|null $batchs_count
 * @property-read int $sku_stock_num
 * @property-read mixed $standard_str
 * @property-read \App\Models\ApplyForOrderModel $order
 * @property-read \App\Models\ProductSkuModel $sku
 * @property-read \App\Models\SkuStockModel $sku_stock
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForItemModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForItemModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForItemModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForItemModel whereActualNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForItemModel whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForItemModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForItemModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForItemModel whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForItemModel wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForItemModel whereShouldNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForItemModel whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForItemModel whereStandard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForItemModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApplyForItemModel extends BaseModel
{
    use HasStandard;
    protected $table = 'apply_for_item';

    protected $with = ['sku'];

    protected $appends = ['sku_stock_num', 'standard_str'];

    public function sku(): BelongsTo
    {
        return $this->belongsTo(ProductSkuModel::class, 'sku_id');
    }

    public function getSkuStockNumAttribute(): int
    {
        return $this->sku_stock()->value('num') ?? 0;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(ApplyForOrderModel::class, 'order_id');
    }

    public function batchs(): HasMany
    {
        return $this->hasMany(ApplyForBatchModel::class, 'item_id');
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
