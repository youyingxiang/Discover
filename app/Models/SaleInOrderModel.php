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

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\SaleInOrderModel
 *
 * @property int $id
 * @property string $order_no 订单单号
 * @property int $customer_id 客户档案
 * @property int $status 状态
 * @property string $other 备注
 * @property int $user_id 创建订单用户
 * @property string|null $finished_at 订单完成时间
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $with_id 相关单据id
 * @property int $review_status 审核状态
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|SaleInOrderModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel whereReviewStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel whereWithId($value)
 * @method static \Illuminate\Database\Query\Builder|SaleInOrderModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SaleInOrderModel withoutTrashed()
 * @mixin \Eloquent
 * @property int $address_id 客户地址
 * @property int $drawee_id 付款人
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleInOrderModel whereDraweeId($value)
 */
class SaleInOrderModel extends BaseModel
{
    use SoftDeletes;

    protected $table = 'sale_in_order';
}
