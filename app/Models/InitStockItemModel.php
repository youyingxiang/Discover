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

use App\Traits\HasStandard;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\InitStockItemModel
 *
 * @property int $id
 * @property int $order_id 订单id
 * @property int $sku_id skuId
 * @property string $percent 含绒量
 * @property int $standard 检验标准
 * @property int $actual_num 期初库存
 * @property string $cost_price 成本价格
 * @property int $position_id 库位
 * @property string $batch_no 批次号
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $standard_str
 * @property-read \App\Models\PositionModel $position
 * @property-read \App\Models\ProductSkuModel $sku
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockItemModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockItemModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|InitStockItemModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockItemModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockItemModel whereActualNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockItemModel whereBatchNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockItemModel whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockItemModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockItemModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockItemModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockItemModel whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockItemModel wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockItemModel wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockItemModel whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockItemModel whereStandard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InitStockItemModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|InitStockItemModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InitStockItemModel withoutTrashed()
 * @mixin \Eloquent
 */
class InitStockItemModel extends BaseModel
{
    use SoftDeletes,HasStandard;

    protected $table = 'init_stock_item';

    protected $with = ['sku'];

    public function sku(): BelongsTo
    {
        return $this->belongsTo(ProductSkuModel::class, 'sku_id');
    }

    public function position():BelongsTo
    {
        return $this->belongsTo(PositionModel::class, 'position_id');
    }
}
