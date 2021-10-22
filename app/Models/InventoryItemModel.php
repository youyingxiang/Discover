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
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\InventoryItemModel
 *
 * @property int $id
 * @property int $order_id 订单id
 * @property int $stock_batch_id 批次库存id
 * @property string $should_num 库存数量
 * @property string $actual_num 实盘数量
 * @property string $diff_num 盈亏数量
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $cost_price 成本单价
 * @property-read mixed $diff_cost_price
 * @property-read \App\Models\SkuStockBatchModel $stock_batch
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|InventoryItemModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemModel whereActualNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemModel whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemModel whereDiffNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemModel whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemModel whereShouldNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemModel whereStockBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|InventoryItemModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InventoryItemModel withoutTrashed()
 * @mixin \Eloquent
 */
class InventoryItemModel extends BaseModel
{
    use SoftDeletes;

    protected $table = 'inventory_item';

    /**
     * @return BelongsTo
     */
    public function stock_batch():BelongsTo
    {
        return $this->belongsTo(SkuStockBatchModel::class, 'stock_batch_id');
    }

    public function getDiffCostPriceAttribute()
    {
        return bcmul($this->diff_num, $this->cost_price, 2);
    }
}
