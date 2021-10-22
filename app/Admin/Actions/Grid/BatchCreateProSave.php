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

namespace App\Admin\Actions\Grid;

use App\Models\ProductModel;
use Dcat\Admin\Grid\BatchAction;
use Illuminate\Http\Request;

class BatchCreateProSave extends BatchAction
{
    /**
     * @return string
     */
    protected $title = '保存';

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $products;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $order;

    /**
     * @return string
     */
    protected function html(): string
    {
        return <<<HTML
<a {$this->formatHtmlAttributes()}><button class="btn btn-primary btn-mini"><i class="feather icon-user-check"></i> {$this->title()}</button></a>
HTML;
    }

    public function handle(Request $request)
    {
        $index       = $request->input("_index");
        $order_model = $request->input("_order_model");
        $order_id    = $request->input('_order_id');

        $this->order    = ("\\App\Models\\" . $order_model)::findOrFail($order_id);
        $this->products = ProductModel::whereIn('id', $this->getKey())->get();

        $func = 'save' . $order_model;

        if (method_exists($this, $func)) {
            \call_user_func([$this, $func]);
        }

        return $this->response()->script("parent.layer.close({$index})");
    }

    /**
     * @see 批量新增到采购订单明细
     */
    public function savePurchaseOrderModel(): void
    {
        $this->order->items()->createMany($this->products->map(function (ProductModel $productModel) {
            return ['sku_id' => $productModel->sku_pluck->keys()->first()];
        }));
    }

    /**
     * @see 客户要货单
     */
    public function saveSaleOrderModel(): void
    {
        $this->order->items()->createMany($this->products->map(function (ProductModel $productModel) {
            return ['sku_id' => $productModel->sku_pluck->keys()->first()];
        }));
    }

    /**
     * @see 采购入库
     */
    public function savePurchaseInOrderModel(): void
    {
        $this->order->items()->createMany($this->products->map(function (ProductModel $productModel) {
            return [
                'sku_id'   => $productModel->sku_pluck->keys()->first(),
                'batch_no' => 'PC' . date('Ymd'),
            ];
        }));
    }

    /**
     * @see 销售出库
     */
    public function saveSaleOutOrderModel(): void
    {
        $this->order->items()->createMany($this->products->map(function (ProductModel $productModel) {
            return [
                'sku_id'   => $productModel->sku_pluck->keys()->first(),
                'batch_no' => 'PC' . date('Ymd'),
            ];
        }));
    }

    /**
     * @see 物料申请
     */
    public function saveApplyForOrderModel(): void
    {
        $this->order->items()->createMany($this->products->map(function (ProductModel $productModel) {
            return [
                'sku_id'   => $productModel->sku_pluck->keys()->first(),
                'batch_no' => 'PC' . date('Ymd'),
            ];
        }));
    }

    public function saveInitStockOrderModel(): void
    {
        $this->order->items()->createMany($this->products->map(function (ProductModel $productModel) {
            return [
                'sku_id'   => $productModel->sku_pluck->keys()->first(),
                'batch_no' => 'PC' . date('Ymd'),
            ];
        }));
    }

    public function actionScript(): string
    {
        $warning     = "请选择保存的数据！";
        $order_id    = request()->input("order_id");
        $order_model = request()->input("order_model");

        return <<<JS
function (data, target, action) {
    var key = {$this->getSelectedKeysScript()}

    if (key.length === 0) {
        Dcat.warning('{$warning}');
        return false;
    }
    data["_order_id"] = "{$order_id}";
    data["_order_model"] = "{$order_model}";
    data["_index"] = parent.layer.getFrameIndex(window.name);
    // 设置主键为复选框选中的行ID数组
    action.options.key = key;
}
JS;
    }
}
