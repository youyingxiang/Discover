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
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CheckProductModel
 *
 * @property int $id
 * @property int $sku_stock_batch_id 关联批次库存id
 * @property int $standard 检验标准
 * @property string $carbon_fiber 碳纤维
 * @property string $percent 含绒量
 * @property string $raw_footage 毛片
 * @property string $velvet 朵绒
 * @property string $magazine 杂志
 * @property string $fluffy_silk 绒丝
 * @property string $terrestrial_feather 陆禽毛
 * @property string $feather_silk 羽丝
 * @property string $heterochromatic_hair 异色毛
 * @property string $flower_number 朵数
 * @property string $blackhead 黑头
 * @property string $cleanliness 清洁度
 * @property string $moisture 水份
 * @property string $bulkiness 蓬松度
 * @property string $odor 气味
 * @property string $duck_ratio 鸭比
 * @property int $user_id 质检员
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $order_no 订单号
 * @property int $prev_sku_stock_batch_id 关联批次库存id
 * @property-read mixed $standard_str
 * @property-read Administrator $user
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|CheckProductModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereBlackhead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereBulkiness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereCarbonFiber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereCleanliness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereDuckRatio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereFeatherSilk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereFlowerNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereFluffySilk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereHeterochromaticHair($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereMagazine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereMoisture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereOdor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel wherePrevSkuStockBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereRawFootage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereSkuStockBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereStandard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereTerrestrialFeather($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckProductModel whereVelvet($value)
 * @method static \Illuminate\Database\Query\Builder|CheckProductModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CheckProductModel withoutTrashed()
 * @mixin \Eloquent
 */
class CheckProductModel extends BaseModel
{
    use HasDateTimeFormatter;
    use SoftDeletes;
    use HasStandard;
    protected $appends = ['standard_str'];
    protected $table = 'check_product';

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'user_id');
    }
}
