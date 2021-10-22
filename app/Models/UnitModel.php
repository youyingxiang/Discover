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
 * App\Models\UnitModel
 *
 * @property int $id
 * @property string $name 单位名称
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UnitModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|UnitModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|UnitModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UnitModel withoutTrashed()
 * @mixin \Eloquent
 */
class UnitModel extends BaseModel
{
    use SoftDeletes;
    protected $table = 'unit';
}
