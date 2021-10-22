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

namespace App\Services;

use App\Models\PositionModel;
use App\Models\PurchaseInOrderModel;
use App\Models\PurchaseItemModel;
use App\Models\PurchaseOrderModel;
use App\Models\SaleItemModel;
use App\Models\SaleOrderModel;
use App\Models\SaleOutOrderModel;
use Yxx\LaravelQuick\Services\BaseService;

class OrderService extends BaseService
{
    /**
     * @var
     */
    protected $default_position_id;

    /**
     * @param array $params
     */
    public function withOrder(array $params): void
    {
        $func          = "syncTo" . $params['func'];
        $order_no      = $params['order_no'];
        $with_order_id = $params['with_order_id'];
        $this->default_position_id = PositionModel::value('id') ?? 0;
        if (method_exists($this, $func)) {
            \call_user_func_array([$this, $func], [$order_no, $with_order_id]);
        }
    }

    /**
     * @param string $order_no
     * @param int $with_order_id
     */
    public function syncToPurchaseInOrder(string $order_no, int $with_order_id): void
    {
        $purchase_order    = PurchaseOrderModel::findOrFail($with_order_id);
        $purchase_in_order = PurchaseInOrderModel::where('order_no', $order_no)->first();

        $items = $purchase_order->items->map(function (PurchaseItemModel $purchaseItemModel) {
            return [
                'sku_id'      => $purchaseItemModel->sku_id,
                'should_num'  => $purchaseItemModel->should_num,
                'actual_num'  => $purchaseItemModel->should_num,
                'price'       => $purchaseItemModel->price,
                'percent'     => $purchaseItemModel->percent,
                'standard'    => $purchaseItemModel->standard,
                'batch_no'    => 'PC' . date('Ymd'),
                'position_id' => $this->default_position_id,
            ];
        });

        $purchase_in_order->items()->delete();
        $purchase_in_order->items()->createMany($items);

        $purchase_in_order->with_id = $with_order_id;
        $purchase_in_order->save();
    }

    /**
     * @param string $order_no
     * @param int $with_order_id
     */
    public function syncToSaleOutOrder(string $order_no, int $with_order_id): void
    {
        $sale_order = SaleOrderModel::findOrFail($with_order_id);
        $sale_out_order = SaleOutOrderModel::where('order_no', $order_no)->first();

        $items = $sale_order->items->map(function (SaleItemModel $saleItemModel) {
            return [
                'sku_id'      => $saleItemModel->sku_id,
                'should_num'  => $saleItemModel->should_num,
                'price'       => $saleItemModel->price,
                'percent'     => $saleItemModel->percent,
                'standard'    => $saleItemModel->standard,
            ];
        });

        $sale_out_order->items()->delete();
        $sale_out_order->items()->createMany($items);

        $sale_out_order->with_id = $with_order_id;
        $sale_out_order->save();
    }
}
