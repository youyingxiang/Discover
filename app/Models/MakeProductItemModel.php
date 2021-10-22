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

/**
 * App\Models\MakeProductItemModel
 *
 * @property int $id
 * @property int $order_id 关联单据
 * @property int $sku_id 生产入库商品的skuid
 * @property string $should_num 计划入库数量
 * @property string $actual_num 实际入库数量
 * @property string $cost_price 成本价格
 * @property int $position_id 位置id
 * @property string $batch_no 批次号
 * @property string $percent 含绒量
 * @property int $standard 检验标准
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $standard_str
 * @property-read \App\Models\MakeProductOrderModel $order
 * @property-read \App\Models\PositionModel $position
 * @property-read \App\Models\ProductSkuModel $sku
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductItemModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductItemModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductItemModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductItemModel whereActualNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductItemModel whereBatchNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductItemModel whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductItemModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductItemModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductItemModel whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductItemModel wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductItemModel wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductItemModel whereShouldNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductItemModel whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductItemModel whereStandard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MakeProductItemModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MakeProductItemModel extends BaseModel
{
    use HasStandard;
    protected $table = 'make_product_item';

    protected $with = ['sku'];

    protected $appends = ['standard_str'];

    public function sku(): BelongsTo
    {
        return $this->belongsTo(ProductSkuModel::class, 'sku_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(MakeProductOrderModel::class, 'order_id');
    }

    public function position():BelongsTo
    {
        return $this->belongsTo(PositionModel::class, 'position_id');
    }
}
