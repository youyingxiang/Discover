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

use App\Admin\Renderables\SkuStockBatchTable;
use App\Admin\Repositories\SkuStock;
use App\Models\SkuStockBatchModel;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Database\Eloquent\Builder;

class SkuStockController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SkuStock(['sku.product']), function (Grid $grid) {
            $grid->model()->where('num', ">", 0);
            $grid->column('id')->sortable();
            $grid->column('sku.product.item_no', '产品编号');
            $grid->column('sku.product.name', '产品名称');
            $grid->column('sku.product.unit.name', '单位');
            $grid->column('sku.product.type_str', '类型');
            $grid->column('sku.attr_value_ids_str', '属性');
            $grid->column('percent', '含绒量(%)');
            $grid->column('standard_str', '检验标准');
            $grid->column('num');
            $grid->column('batch_num', '批次库存')->expand(function () {
                return SkuStockBatchTable::make(['sku_id' => $this->sku_id, 'percent' => $this->percent]);
            });
//            $grid->column('created_at');
//            $grid->column('updated_at')->sortable();
            $grid->disableRowSelector();
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
                $filter->group('num', function ($group) {
                    $group->gt('大于');
                    $group->lt('小于');
                    $group->nlt('不小于');
                    $group->ngt('不大于');
                    $group->equal('等于');
                })->width(3);
                $filter->like('percent', "含绒量")->decimal()->width(3);
                $filter->equal('standard', "检验标准")->select(SkuStockBatchModel::STANDARD)->width(3);
            });
            $grid->disableActions();
            $grid->disableCreateButton();
        });
    }
}
