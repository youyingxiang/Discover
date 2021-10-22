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
use Tests\Models\User;

/**
 * App\Models\StatementOrderModel
 *
 * @property int $id
 * @property string $order_no 订单号
 * @property int $category 费用分类
 * @property int $company_id 公司id
 * @property string $other 备注
 * @property int $apply_id 审核人
 * @property int $review_status 审核状态
 * @property string $should_amount 应付金额
 * @property string $actual_amount 实付金额
 * @property string $discount_amount 优惠金额
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|StatementOrderModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel whereActualAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel whereApplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel whereReviewStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel whereShouldAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|StatementOrderModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|StatementOrderModel withoutTrashed()
 * @mixin \Eloquent
 */
class StatementOrderModel extends BaseModel
{
    protected $table = 'statement_order';

    protected $appends = ['company_name', 'category_str'];

    const CATEGORY_CUSTOMER = 0;
    const CATEGORY_SUPPLIER = 1;
    const CATEGORY = [
        self::CATEGORY_CUSTOMER => "客户",
        self::CATEGORY_SUPPLIER => "供应商",
    ];

    public function items():HasMany
    {
        return $this->hasMany(StatementItemModel::class, 'order_id');
    }

    /**
     * @return string
     */
    public function getCompanyNameAttribute():string
    {
        if ($this->category === self::CATEGORY_SUPPLIER) {
            return SupplierModel::query()->where('id', $this->company_id)->value('name');
        }
        return CustomerModel::query()->where('id', $this->company_id)->value('name');
    }

    /**
     * @return string
     */
    public function getCateGoryStrAttribute(): string
    {
        return self::CATEGORY[$this->category];
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function apply_user(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'apply_id');
    }
}
