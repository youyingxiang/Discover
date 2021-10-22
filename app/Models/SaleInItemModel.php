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
 * App\Models\SaleInItemModel
 *
 * @property int $id
 * @property int $order_id 订单id
 * @property int $sku_id 商品的skuid
 * @property int $should_num 销售数量
 * @property int $actual_num 出库数量
 * @property int $return_num 退回数量
 * @property string $price 价格
 * @property int $position_id 位置id
 * @property string $batch_no 批次号
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel whereActualNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel whereBatchNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel whereReturnNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel whereShouldNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $percent 含绒量
 * @property int $standard 检验标准
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInItemModel whereStandard($value)
 */
class SaleInItemModel extends BaseModel
{
    protected $table = 'sale_in_item';
}
