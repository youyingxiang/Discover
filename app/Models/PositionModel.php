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
 * App\Models\PositionModel
 *
 * @property int $id
 * @property string $name 位置名称
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PositionModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PositionModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|PositionModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PositionModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|PositionModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PositionModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PositionModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PositionModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PositionModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|PositionModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PositionModel withoutTrashed()
 * @mixin \Eloquent
 */
class PositionModel extends BaseModel
{
    use SoftDeletes;

    protected $table = 'position';
}
