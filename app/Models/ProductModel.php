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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * App\Models\ProductModel
 *
 * @property int $id
 * @property string $name 产品名称
 * @property string $py_code 拼音码
 * @property string $item_no 产品编号
 * @property int $unit_id 单位
 * @property mixed $test 测试
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttrModel[] $attrs
 * @property-read int|null $attrs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductAttrModel[] $product_attr
 * @property-read int|null $product_attr_count
 * @property-read \App\Models\UnitModel $unit
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProductModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereItemNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel wherePyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereTest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ProductModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductModel withoutTrashed()
 * @mixin \Eloquent
 * @property-read array $attr_value_arr
 * @property-read array $sku_id_text
 * @property-read array $sku_key_value
 * @property-read Collection $sku_pluck
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductSkuModel[] $sku
 * @property-read int|null $sku_count
 * @property int $type 类型
 * @property-read string $type_str
 * @method static \Illuminate\Database\Eloquent\Builder|ProductModel whereType($value)
 */
class ProductModel extends BaseModel
{
    use SoftDeletes;

    protected $table = 'product';

    protected $with = ['product_attr', 'unit', 'sku'];

    protected $appends = ['attr_value_arr', 'sku_key_value', 'sku_pluck', 'sku_id_text', 'type_str'];

    const TYPE_FINISH = 1;
    const TYPE_NOT_FINISH = 0;

    const TYPE = [
        self::TYPE_NOT_FINISH => '半成品',
        self::TYPE_FINISH => '成品',
    ];
    /**
     * @return BelongsToMany
     */
    public function attrs(): BelongsToMany
    {
        return $this->belongsToMany(AttrModel::class);
    }

    /**
     * @return HasMany
     */
    public function product_attr(): HasMany
    {
        return $this->hasMany(ProductAttrModel::class, 'product_id');
    }

    public function getTypeStrAttribute(): string
    {
        return self::TYPE[$this->type];
    }

    /**
     * @return BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(UnitModel::class);
    }

    public function getAttrValueArrAttribute(): array
    {
        $attr_value_ids = $this->product_attr->pluck('attr_value_ids');
        return $attr_value_ids ? attrCrossJoin($attr_value_ids) : [];
    }

    /**
     * @return HasMany
     */
    public function sku(): HasMany
    {
        return $this->hasMany(ProductSkuModel::class, 'product_id');
    }

    /**
     * @return array
     */
    public function getSkuKeyValueAttribute(): array
    {
        return Arr::pluck($this->sku_id_text, 'text', 'id');
    }

    public function getSkuIdTextAttribute(): array
    {
        return $this->sku->map(function (ProductSkuModel $productSkuModel) {
            return [
                'id'   => $productSkuModel->id,
                'text' => $productSkuModel->attr_value_ids_str,
            ];
        })->values()->toArray() ?? [];
    }

    /**
     * @return Collection
     */
    public function getSkuPluckAttribute(): Collection
    {
        return $this->sku->pluck('attr_value_ids', 'id') ?? collect();
    }
}
