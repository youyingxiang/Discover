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
 * App\Models\SaleOutBatchModel
 *
 * @property int $id
 * @property int $item_id 订单明细id
 * @property int $actual_num 出库数量
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $stock_batch_id 出库产品批次id
 * @property string $percent 含绒量
 * @property int $standard 检验标准
 * @property-read \App\Models\SaleOutItemModel $item
 * @property-read \App\Models\SkuStockBatchModel $stock_batch
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutBatchModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutBatchModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutBatchModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutBatchModel whereActualNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutBatchModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutBatchModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutBatchModel whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutBatchModel wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutBatchModel whereStandard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutBatchModel whereStockBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleOutBatchModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SaleOutBatchModel extends BaseModel
{
    protected $table = 'sale_out_batch';

    protected $with = ['item', 'stock_batch'];

    public function item():BelongsTo
    {
        return $this->belongsTo(SaleOutItemModel::class, 'item_id');
    }

    /**
     * @return BelongsTo
     */
    public function stock_batch():BelongsTo
    {
        return $this->belongsTo(SkuStockBatchModel::class, 'stock_batch_id');
    }
}
