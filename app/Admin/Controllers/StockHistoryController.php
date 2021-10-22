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

namespace App\Admin\Controllers;

use App\Admin\Repositories\StockHistory;
use App\Models\SkuStockBatchModel;
use App\Models\StockHistoryModel;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Database\Eloquent\Builder;

class StockHistoryController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new StockHistory(['sku.product']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->combine('入库信息', ['in_num', 'in_position.name', 'in_price']);
            $grid->combine('出库信息', ['out_num', 'out_position.name', 'out_price']);
            $grid->combine('产品信息', ['sku.product.item_no', 'sku.product.name', 'sku.product.unit.name', 'sku.product.type_str', 'sku.attr_value_ids_str', 'percent', 'standard_str']);
            $grid->combine("盘点信息", ["inventory_num", "inventory_diff_num"]);
            $grid->combine('库存信息', ['init_num', 'balance_num', 'batch_no', 'cost_price']);

            $grid->column('flag')->using(StockHistoryModel::FLAG);
            $grid->column('type')->using(StockHistoryModel::TYPE);
            $grid->column('user.name', '操作用户');
            $grid->column('with_order_no');
            $grid->column('in_num');
            $grid->column('in_position.name', '入库位置')->emp();
            $grid->column('in_price');

            $grid->column('out_num');
            $grid->column('out_position.name', '出库位置')->emp();
            $grid->column('out_price');
            $grid->column('sku.product.item_no', '产品编号');
            $grid->column('sku.product.name', '产品名称');
            $grid->column('sku.product.unit.name', '单位');
            $grid->column('sku.product.type_str', '类型');
            $grid->column('sku.attr_value_ids_str', '属性');
            $grid->column('percent', '含绒量(%)');
            $grid->column('standard_str', '检验标准');
            $grid->column('cost_price');
            $grid->column('batch_no');
            $grid->column('init_num');
            $grid->column('inventory_num', "盘点数量");
            $grid->column('inventory_diff_num', "盈亏数量");
            $grid->column('balance_num');
            $grid->column('created_at');

            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableRowSelector();

//            $grid->fixColumns(0);

            $grid->filter(function (Grid\Filter $filter) {
                $filter->where("product_name", function (Builder $query) {
                    $query->whereHasIn("sku.product", function (Builder $query) {
                        $query->where(function (Builder $query) {
                            $query->orWhere("name", "like", $this->getValue()."%");
                            $query->orWhere("py_code", "like", $this->getValue()."%");
                            $query->orWhere('item_no', 'like', $this->getValue()."%");
                        });
                    });
                }, "关键字")->placeholder("产品名称，拼音码，编号")->width(3);
                $filter->like('with_order_no')->width(3);
                $filter->equal('type')->select(StockHistoryModel::TYPE)->width(3);
                $filter->equal('flag')->select(StockHistoryModel::FLAG)->width(3);
                $filter->like('percent', "含绒量")->decimal()->width(3);
                $filter->equal('standard', "检验标准")->select(SkuStockBatchModel::STANDARD)->width(3);
                $filter->like('batch_no', "批次号")->width(3);
            });
        });
    }
}
