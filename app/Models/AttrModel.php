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

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\AttrModel
 *
 * @property int $id
 * @property string $name 属性名称
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttrValueModel[] $values
 * @property-read int|null $values_count
 * @method static \Illuminate\Database\Eloquent\Builder|AttrModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttrModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|AttrModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AttrModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttrModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttrModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttrModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttrModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttrModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|AttrModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AttrModel withoutTrashed()
 * @mixin \Eloquent
 */
class AttrModel extends BaseModel
{
    use SoftDeletes;

    protected $table = 'attr';

    public function values():HasMany
    {
        return $this->hasMany(AttrValueModel::class, 'attr_id');
    }
}
