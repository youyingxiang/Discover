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
use Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\StockHistoryModel
 *
 * @property int $id
 * @property int $sku_id sku_id
 * @property int $in_position_id 入库位置
 * @property int $out_position_id 出库位置
 * @property string $cost_price 成本价格
 * @property int $type 业务类型
 * @property int $flag 出入库标志
 * @property string $with_order_no 相关单号
 * @property int $init_num 期初库存
 * @property int $in_num 入库数量
 * @property string $in_price 入库价格
 * @property int $out_num 出库数量
 * @property string $out_price 出库价格
 * @property int $balance_num 结余库存
 * @property int $user_id 操作用户
 * @property string $batch_no 批次号
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereBalanceNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereBatchNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereInNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereInPositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereInPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereInitNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereOutNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereOutPositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereOutPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereWithOrderNo($value)
 * @mixin \Eloquent
 * @property-read \App\Models\PositionModel $in_position
 * @property-read \App\Models\PositionModel $out_position
 * @property-read \App\Models\ProductSkuModel $sku
 * @property-read Administrator $user
 * @property string $percent 含绒量
 * @property int $standard 检验标准
 * @property string $inventory_num 盘点数量
 * @property string $inventory_diff_num 盘点盈亏数量
 * @property-read mixed $standard_str
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereInventoryDiffNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereInventoryNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHistoryModel whereStandard($value)
 */
class StockHistoryModel extends BaseModel
{
    use HasStandard;
    protected $table = 'stock_history';
    protected $with = ['user', 'in_position', 'out_position', 'sku'];
    protected $appends = ['standard_str'];

    const OUT_STOCK_PUCHASE = 0;
    const IN_STOCK_PUCHASE = 1;
    const INVENTORY_TYPE = 2;
    const PRO_STOCK_TYPE = 3;
    const COLLECTION_TYPE = 4;
    const TRANSFER_TYPE = 5;
    const STORE_OUT_TYPE = 6;
    const INIT_TYPE = 7;
    const SCRAP_TYPE = 8;
    const CHECK_IN_TYPE = 9;
    const CHECK_OUT_TYPE = 10;

    const TYPE = [
        self::OUT_STOCK_PUCHASE => "采购退货",
        self::IN_STOCK_PUCHASE => "采购入库",
        self::INVENTORY_TYPE => "库存盘点",
        self::PRO_STOCK_TYPE => "生产入库",
        self::COLLECTION_TYPE => "物料申领",
        self::TRANSFER_TYPE => "库存调拨",
        self::STORE_OUT_TYPE => "销售出库",
        self::INIT_TYPE => "期初建账",
        self::SCRAP_TYPE => '物料报废',
        self::CHECK_IN_TYPE => '检验入库',
        self::CHECK_OUT_TYPE => '检验出库',
    ];

    const OUT = 0;
    const IN = 1;
    const INVENTORY = 2;
    const TRANSFER = 3;
    const FLAG = [
        self::IN => "入库",
        self::OUT => "出库",
        self::INVENTORY => "盘点",
        self::TRANSFER => '调拨',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function in_position():BelongsTo
    {
        return $this->belongsTo(PositionModel::class, 'in_position_id');
    }

    /**
     * @return BelongsTo
     */
    public function out_position():BelongsTo
    {
        return $this->belongsTo(PositionModel::class, 'out_position_id');
    }

    /**
     * @return BelongsTo
     */
    public function sku(): BelongsTo
    {
        return $this->belongsTo(ProductSkuModel::class, 'sku_id');
    }
}
