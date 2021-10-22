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

/**
 * App\Models\OrderNoGeneratorModel
 *
 * @property int $id
 * @property string $prefix 订单前缀
 * @property string $happen_date 日期
 * @property int $number 序号
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNoGeneratorModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNoGeneratorModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNoGeneratorModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNoGeneratorModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNoGeneratorModel whereHappenDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNoGeneratorModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNoGeneratorModel whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNoGeneratorModel wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNoGeneratorModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderNoGeneratorModel extends BaseModel
{
    protected $table = 'order_no_generator';
}
