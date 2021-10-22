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

namespace App\Admin\Extensions\Grid;

use App\Models\SaleOutBatchModel;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Table;

class SaleBatchDetail extends LazyRenderable
{
    public function render()
    {
        $data = SaleOutBatchModel::query()
            ->where('item_id', $this->key)
            ->get()
            ->transform(function (SaleOutBatchModel $batchModel) {
                return [
                    $batchModel->stock_batch->batch_no,
                    $batchModel->actual_num,
                    $batchModel->cost_price,
                    bcmul($batchModel->actual_num, $batchModel->cost_price, 2)
                ];
            });
        $titles = [
            "批次号",
            "出库数量",
            "成本价格",
            "成本合计"
        ];
        return Table::make($titles, $data->toArray());
    }
}
