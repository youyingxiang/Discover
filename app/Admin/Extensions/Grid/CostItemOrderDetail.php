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

use App\Models\CostItemModel;
use App\Models\PurchaseInItemModel;
use App\Models\SaleOutItemModel;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Table;

class CostItemOrderDetail extends LazyRenderable
{
    public function render()
    {
        switch ($this->cost_type) {
            case CostItemModel::COST_TYPE_SALE:
                $items = SaleOutItemModel::query()->where('order_id', $this->with_id)->get();
                $items->transform(function (SaleOutItemModel $itemModel) {
                    return [
                        $itemModel->sku->product->name,
                        $itemModel->sku->product->unit->name,
                        $itemModel->sku->product->type_str,
                        $itemModel->sku->attr_value_ids_str,
                        $itemModel->percent,
                        $itemModel->standard_str,
                        $itemModel->should_num,
                        $itemModel->actual_num,
                        bcmul($itemModel->actual_num, $itemModel->price, 2)
                    ];
                });
                $titles = [
                    '产品名称',
                    '单位',
                    '类型',
                    '属性',
                    '含绒百分比',
                    '检验标准',
                    '要货数量',
                    '销售数量',
                    '合计',
                ];
                break;
            case CostItemModel::COST_TYPE_PURCHASE:
                $items = PurchaseInItemModel::query()->where('order_id', $this->with_id)->get();
                $items->transform(function (PurchaseInItemModel $itemModel) {
                    return [
                        $itemModel->sku->product->name,
                        $itemModel->sku->product->unit->name,
                        $itemModel->sku->product->type_str,
                        $itemModel->sku->attr_value_ids_str,
                        $itemModel->percent,
                        $itemModel->standard_str,
                        $itemModel->should_num,
                        $itemModel->actual_num,
                        bcmul($itemModel->actual_num, $itemModel->price, 2)
                    ];
                });
                $titles = [
                    '产品名称',
                    '单位',
                    '类型',
                    '属性',
                    '含绒百分比',
                    '检验标准',
                    '采购数量',
                    '入库数量',
                    '合计',
                ];
                break;
        }

        return Table::make($titles, $items->toArray());
    }
}
