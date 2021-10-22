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

/**
 * App\Models\AccountantDateModel
 *
 * @property int $id
 * @property int $year 会计年
 * @property int $day 结算天
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $day_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AccountantDateItemModel[] $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateModel whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateModel whereDayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateModel whereYear($value)
 * @mixin \Eloquent
 */
class AccountantDateModel extends BaseModel
{
    protected $table = 'accountant_date';

    const DEFAULT = 0;
    const CUSTOMIZE = 1;
    const TYPE = [
        self::DEFAULT => '自然月',
        self::CUSTOMIZE => '自定义',
    ];

    public function items():HasMany
    {
        return $this->hasMany(AccountantDateItemModel::class, 'accountant_date_id');
    }
}
