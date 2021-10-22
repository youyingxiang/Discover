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
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\CostOrderModel
 *
 * @property int $id
 * @property string $order_no
 * @property int $category
 * @property string $other
 * @property int $user_id
 * @property int $apply_id
 * @property int $review_status
 * @property int $accountant_item_id
 * @property string $total_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $company_name
 * @property int $company_id
 * @property-read \App\Models\AccountantDateItemModel $accountant_item
 * @property-read Administrator $apply_user
 * @property-read mixed $cate_gory_str
 * @property-read string $year_month
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CostItemModel[] $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|CostOrderModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel whereAccountantItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel whereApplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel whereReviewStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostOrderModel whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|CostOrderModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CostOrderModel withoutTrashed()
 * @mixin \Eloquent
 */
class CostOrderModel extends BaseModel
{
    const CATEGORY_CUSTOMER = 0;
    const CATEGORY_SUPPLIER = 1;
    const CATEGORY = [
        self::CATEGORY_CUSTOMER => "客户",
        self::CATEGORY_SUPPLIER => "供应商",
    ];

    const SETTLEMENT_UNDONE = 0;
    const SETTLEMENT_COMPLETEED = 1;

    protected $table = 'cost_order';

    protected $appends = ['category_str', 'year_month', 'company_str'];

    protected $with = ['accountant_item'];

    public function items():HasMany
    {
        return $this->hasMany(CostItemModel::class, 'order_id');
    }

    public function apply_user(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'apply_id');
    }

    public function getCateGoryStrAttribute()
    {
        return self::CATEGORY[$this->category];
    }

    public function getCompanyStrAttribute():string
    {
        if ($this->category === self::CATEGORY_SUPPLIER) {
            return SupplierModel::query()->where('id', $this->company_id)->value('name');
        }
        return CustomerModel::query()->where('id', $this->company_id)->value('name');
    }

    /**
     * @return string
     */
    public function getYearMonthAttribute():string
    {
        return $this->accountant_item->year_month;
    }

    public function accountant_item():BelongsTo
    {
        return $this->belongsTo(AccountantDateItemModel::class, 'accountant_item_id');
    }
}
