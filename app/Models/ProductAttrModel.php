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
 * App\Models\ProductAttrModel
 *
 * @property int $id
 * @property int $product_id 产品id
 * @property int $attr_id 属性id
 * @property array $attr_value_ids 产品可选值
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttrModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttrModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttrModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttrModel whereAttrId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttrModel whereAttrValueIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttrModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttrModel whereProductId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\AttrModel $attr
 */
class ProductAttrModel extends BaseModel
{
    protected $table = 'product_attr';
    public $timestamps = false;

    protected $casts = [
        'attr_value_ids' => 'json',
    ];

    public function attr(): BelongsTo
    {
        return $this->belongsTo(AttrModel::class, 'attr_id');
    }
}
