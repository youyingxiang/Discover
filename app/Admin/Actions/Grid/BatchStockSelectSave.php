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

use App\Models\ApplyForBatchModel;
use App\Models\InventoryItemModel;
use App\Models\SaleOutBatchModel;
use App\Models\SkuStockBatchModel;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\BatchAction;
use Illuminate\Http\Request;

class BatchStockSelectSave extends BatchAction
{
    /**
     * @return string
     */
    protected $title = '保存';
    /**
     * @var int
     */
    protected $sku_id;
    /**
     * @var int
     */
    protected $item_id;
    /**
     * @var mixed
     */
    protected $standard;
    /**
     * @var mixed
     */
    protected $percent;
    /**
     * @var int
     */
    protected $order_id;

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $func = 'saveTo' . request()->input('_table');

        $this->sku_id = $request->input('_sku_id');

        $this->item_id = $request->input('_item_id');

        $this->standard = $request->input('_standard');

        $this->percent = $request->input('_percent');

        $this->order_id = $request->input('_order_id') ?? 0;

        if (method_exists($this, $func)) {
            \call_user_func([$this, $func]);
        }
        $index = $request->input("_index");

        return $this->response()->script("parent.layer.close({$index})");
    }

    /**
     * @see 批次信息保存到销售出库批次
     */
    protected function saveToSaleOutBatch(): void
    {
        foreach ($this->getKey() as $stock_batch_id) {
            $skuStockBatch = SkuStockBatchModel::query()->findOrFail($stock_batch_id);
            SaleOutBatchModel::create([
                'stock_batch_id' => $stock_batch_id,
                'sku_id'         => $this->sku_id,
                'item_id'        => $this->item_id,
                'standard'       => $this->standard,
                'percent'        => $this->percent,
                'cost_price'     => $skuStockBatch->cost_price,
            ]);
        }
    }

    public function saveToApplyForBatch(): void
    {
        foreach ($this->getKey() as $stock_batch_id) {
            ApplyForBatchModel::create([
                'stock_batch_id' => $stock_batch_id,
                'sku_id'         => $this->sku_id,
                'item_id'        => $this->item_id,
                'standard'       => $this->standard,
                'percent'        => $this->percent,
            ]);
        }
    }

    public function saveToInventoryOrder()
    {
        foreach ($this->getKey() as $stock_batch_id) {
            $skuStockBatch = SkuStockBatchModel::query()->findOrFail($stock_batch_id);
            InventoryItemModel::create([
                'stock_batch_id' => $stock_batch_id,
                'should_num'         => $skuStockBatch->num,
                'actual_num'        => $skuStockBatch->num,
                'order_id'          => $this->order_id,
                'cost_price'        => $skuStockBatch->cost_price,
            ]);
        }
    }

    protected function html(): string
    {
        return <<<HTML
<a {$this->formatHtmlAttributes()}><button class="btn btn-primary btn-mini"><i class="feather icon-user-check"></i> {$this->title()}</button></a>
HTML;
    }

    public function actionScript(): string
    {
        $warning = "请选择保存的数据！";
        $table   = request()->input('table');
        $sku_id  = request()->input('sku_id');
        $item_id = request()->input('item_id');
        $standard = request()->input('standard');
        $percent = request()->input('percent');
        $order_id = request()->input('order_id');

        return <<<JS
function (data, target, action) {
    var key = {$this->getSelectedKeysScript()};

    if (key.length === 0) {
        Dcat.warning('{$warning}');
        return false;
    }
    data["_index"] = parent.layer.getFrameIndex(window.name);
    data["_table"] = "$table";
    data["_sku_id"] = "$sku_id";
    data['_item_id'] = "$item_id";
    data['_standard'] = "$standard";
    data['_percent'] = "$percent";
    data['_order_id'] = "$order_id";

    // 设置主键为复选框选中的行ID数组
    action.options.key = key;
}
JS;
    }
}
