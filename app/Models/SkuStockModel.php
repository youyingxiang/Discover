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
 * App\Models\SkuStockModel
 *
 * @property int $id
 * @property int $sku_id 产品sku_id
 * @property int $num 产品库存
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductSkuModel $sku
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockModel whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockModel whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockModel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $percent 含绒量
 * @property int $standard 检验标准
 * @property-read mixed $standard_str
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockModel wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuStockModel whereStandard($value)
 */
class SkuStockModel extends BaseModel
{
    use HasStandard;

    protected $table = 'sku_stock';

    protected $with = ['sku'];

    protected $appends = ['standard_str'];

    public function sku(): BelongsTo
    {
        return $this->belongsTo(ProductSkuModel::class, 'sku_id');
    }
}
