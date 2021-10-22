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

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\AccountantDateItemModel
 *
 * @property int $id
 * @property int $accountant_date_id 关联id
 * @property string|null $start_at 开始日期
 * @property string|null $end_at 截止日期
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $month
 * @property-read \App\Models\AccountantDateModel $accountant_date
 * @property-read Carbon $full_carbon
 * @property-read string $year_month
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateItemModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateItemModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateItemModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateItemModel whereAccountantDateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateItemModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateItemModel whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateItemModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateItemModel whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateItemModel whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountantDateItemModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AccountantDateItemModel extends BaseModel
{
    protected $table = 'accountant_date_item';

    protected $appends = ['full_carbon', 'year_month'];

    protected $with = ['accountant_date'];

    public function accountant_date():BelongsTo
    {
        return $this->belongsTo(AccountantDateModel::class, 'accountant_date_id');
    }

    public function getYearMonthAttribute():string
    {
        return $this->full_carbon->format("Y年m月");
    }

    public function getFullCarbonAttribute():Carbon
    {
        return Carbon::create($this->accountant_date->year, $this->month);
    }
}
