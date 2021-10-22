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

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\DraweeModel
 *
 * @property int $id
 * @property string $name 付款人名称
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DraweeModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DraweeModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DraweeModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|DraweeModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DraweeModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DraweeModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DraweeModel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CustomerModel[] $customer
 * @property-read int|null $customer_count
 */
class DraweeModel extends BaseModel
{
    protected $table = 'drawee';

    /**
     * @return BelongsToMany
     */
    public function customer(): BelongsToMany
    {
        return $this->belongsToMany(CustomerModel::class, CustomerDraweeModel::class, 'drawee_id', 'customer_id');
    }
}
