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

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ApplyForBatchModel
 *
 * @property int $id
 * @property int $item_id 订单明细id
 * @property string $actual_num 实领数量
 * @property int $stock_batch_id 出库批次库存id
 * @property int $standard 检验标准
 * @property string $percent 含绒量
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ApplyForItemModel $item
 * @property-read \App\Models\SkuStockBatchModel $stock_batch
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForBatchModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForBatchModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForBatchModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForBatchModel whereActualNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForBatchModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForBatchModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForBatchModel whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForBatchModel wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForBatchModel whereStandard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForBatchModel whereStockBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplyForBatchModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApplyForBatchModel extends BaseModel
{
    protected $table = 'apply_for_batch';

    protected $with = ['item', 'stock_batch'];

    public function item():BelongsTo
    {
        return $this->belongsTo(ApplyForItemModel::class, 'item_id');
    }

    /**
     * @return BelongsTo
     */
    public function stock_batch():BelongsTo
    {
        return $this->belongsTo(SkuStockBatchModel::class, 'stock_batch_id');
    }
}
