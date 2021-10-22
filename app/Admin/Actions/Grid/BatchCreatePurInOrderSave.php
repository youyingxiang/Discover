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

use App\Models\PositionModel;
use App\Models\PurchaseInOrderModel;
use App\Models\PurchaseItemModel;
use App\Models\PurchaseOrderModel;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid\BatchAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchCreatePurInOrderSave extends BatchAction
{
    /**
     * @return string
     */
    protected $title = '保存';
    /**
     * @var int
     */
    protected $default_position_id;

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
        $this->default_position_id = PositionModel::value('id') ?? 0;
        DB::transaction(function () {
            foreach ($this->getKey() as $key) {
                $purchase_order = PurchaseOrderModel::findOrFail($key);
                $this->orderSync($purchase_order);
            }
        });
        return $this->response()->script("parent.layer.close({$index})");
    }

    protected function orderSync(PurchaseOrderModel $purchaseOrderModel): void
    {
        $in_order = PurchaseInOrderModel::create([
            'order_no'    => build_order_no('RK'),
            'supplier_id' => $purchaseOrderModel->supplier_id,
            'status'      => PurchaseInOrderModel::STATUS_ARRIVE,
            'other'       => $purchaseOrderModel->other,
            'user_id'     => Admin::user()->id,
            'with_id'     => $purchaseOrderModel->id,
        ]);
        $items    = $purchaseOrderModel->items->map(function (PurchaseItemModel $purchaseItemModel) {
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
        $in_order->items()->createMany($items);
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
