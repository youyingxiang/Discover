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
 * App\Models\SkuStockBatchModel
 *
 * @property int $id
 * @property int $sku_id 产品sku_id
 * @property int $num 产品库存
 * @property int $position_id 仓库位置
 * @property string $batch_no 批次号
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PositionModel $position
 * @property-read \App\Models\ProductSkuModel $sku
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockBatchModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockBatchModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockBatchModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockBatchModel whereBatchNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockBatchModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockBatchModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockBatchModel whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockBatchModel wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockBatchModel whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockBatchModel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $cost_price 成本价
 * @property string $percent 含绒量
 * @property int $standard 检验标准
 * @property-read mixed $standard_str
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockBatchModel whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockBatchModel wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockBatchModel whereStandard($value)
 */
class SkuStockBatchModel extends BaseModel
{
    use HasStandard;

    protected $table = 'sku_stock_batch';

    protected $with = ['sku', 'position'];

    protected $appends = ['standard_str'];

    public function sku(): BelongsTo
    {
        return $this->belongsTo(ProductSkuModel::class, 'sku_id');
    }

    public function position():BelongsTo
    {
        return $this->belongsTo(PositionModel::class, 'position_id');
    }
}
