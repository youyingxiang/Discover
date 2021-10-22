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

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CraftModel
 *
 * @property int $id
 * @property string $name 名称
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|CraftModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CraftModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|CraftModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CraftModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|CraftModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CraftModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CraftModel withoutTrashed()
 * @mixin \Eloquent
 */
class CraftModel extends BaseModel
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'craft';
}
