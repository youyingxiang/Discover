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

use Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\InventoryModel
 *
 * @property int $id
 * @property string $order_no 盘点批次号
 * @property string $start_at 盘点开始时间
 * @property string $end_at 盘点结束时间
 * @property int $user_id 创建人
 * @property string $other 备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $status 状态
 * @property-read \App\Models\InventoryOrderModel|null $order
 * @property-read Administrator $user
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|InventoryModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryModel whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryModel whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryModel whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryModel whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|InventoryModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InventoryModel withoutTrashed()
 * @mixin \Eloquent
 */
class InventoryModel extends BaseModel
{
    use SoftDeletes;
    protected $table = 'inventory';

    const STATUS_NOT_STARTED = 0;
    const STATUS_WAIT = 1;
    const STATUS_FINISH = 2;
    const STATUS_STOP = 3;

    const STATUS = [
        self::STATUS_NOT_STARTED => '未开始',
        self::STATUS_WAIT   => "盘点中",
        self::STATUS_FINISH => "已完成",
        self::STATUS_STOP   => "停止",
    ];

    const STATUS_COLOR = [
        self::STATUS_WAIT      => 'gray',
        self::STATUS_FINISH => 'success',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'user_id');
    }

    public function order():HasOne
    {
        return $this->hasOne(InventoryOrderModel::class, 'with_id');
    }
}
