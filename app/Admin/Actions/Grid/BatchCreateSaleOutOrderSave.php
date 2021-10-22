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

use App\Models\SaleItemModel;
use App\Models\SaleOrderModel;
use App\Models\SaleOutOrderModel;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid\BatchAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchCreateSaleOutOrderSave extends BatchAction
{
    /**
     * @return string
     */
    protected $title = '保存';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $index                     = $request->input('_index');
        DB::transaction(function () {
            foreach ($this->getKey() as $key) {
                $sale_order = SaleOrderModel::findOrFail($key);
                $this->orderSync($sale_order);
            }
        });
        return $this->response()->script("parent.layer.close({$index})");
    }

    protected function orderSync(SaleOrderModel $saleOrderModel): void
    {
        $out_order = SaleOutOrderModel::create([
            'order_no'    => build_order_no('CK'),
            'customer_id' => $saleOrderModel->customer_id,
            'status'      => SaleOutOrderModel::STATUS_SEND,
            'other'       => $saleOrderModel->other,
            'user_id'     => Admin::user()->id,
            'with_id'     => $saleOrderModel->id,
            'address_id'  => $saleOrderModel->address_id,
            'drawee_id'   => $saleOrderModel->drawee_id,
        ]);
        $items    = $saleOrderModel->items->map(function (SaleItemModel $saleItemModel) {
            return [
                'sku_id'      => $saleItemModel->sku_id,
                'should_num'  => $saleItemModel->should_num,
                'price'       => $saleItemModel->price,
                'percent'     => $saleItemModel->percent,
                'standard'    => $saleItemModel->standard,
            ];
        });
        $out_order->items()->createMany($items);
    }

    protected function html(): string
    {
        return <<<HTML
<a {$this->formatHtmlAttributes()}><button class="btn btn-primary btn-mini"><i class="feather icon-user-check"></i> {$this->title()}</button></a>
HTML;
    }

    public function actionScript(): string
    {
        $warning = "请选择入库的明细！";

        return <<<JS
function (data, target, action) {
    var key = {$this->getSelectedKeysScript()}

    if (key.length === 0) {
        Dcat.warning('{$warning}');
        return false;
    }
    data["_index"] = parent.layer.getFrameIndex(window.name);

    // 设置主键为复选框选中的行ID数组
    action.options.key = key;
}
JS;
    }
}
