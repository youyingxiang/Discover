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
 * App\Models\ProductSkuModel
 *
 * @property int $id
 * @property int $product_id 产品id
 * @property mixed $attr_value_ids 选项值ids
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkuModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkuModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkuModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkuModel whereAttrValueIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkuModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkuModel whereProductId($value)
 * @mixin \Eloquent
 * @property-read string $attr_value_ids_str
 * @property-read \App\Models\ProductModel $product
 */
class ProductSkuModel extends BaseModel
{
    protected $table = 'product_sku';
    public $timestamps = false;

//    protected $with = ['product'];

    protected $appends = ['attr_value_ids_str'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

    public function getAttrValueIdsStrAttribute(): string
    {
        if (! $this->attr_value_ids) {
            return '';
        }
        return AttrValueModel::getAttrValues()->only(explode(',', $this->attr_value_ids))->implode(',');
    }
}
