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

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\AttrValueModel
 *
 * @property int $id
 * @property int $attr_id 属性id
 * @property string $name 属性值名称
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AttrValueModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttrValueModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|AttrValueModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AttrValueModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttrValueModel whereAttrId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttrValueModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttrValueModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttrValueModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttrValueModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttrValueModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|AttrValueModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AttrValueModel withoutTrashed()
 * @mixin \Eloquent
 */
class AttrValueModel extends BaseModel
{
    use SoftDeletes;

    protected $table = 'attr_value';

    private static $attr_values = null;

    public static function getAttrValues()
    {
        if (self::$attr_values === null) {
            self::$attr_values = static::pluck('name', 'id');
        }
        return self::$attr_values;
    }
}
