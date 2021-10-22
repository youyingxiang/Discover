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

use App\Admin\Actions\Grid\BatchStockSelectSave;
use App\Admin\Actions\Grid\ProductCheck;
use App\Admin\Extensions\Grid\ProductCheckDetails;
use App\Admin\Repositories\SkuStockBatch;
use App\Models\PositionModel;
use App\Models\SkuStockBatchModel;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Database\Eloquent\Builder;

class SkuStockBatchController extends AdminController
{
    public $title = "批次库存";

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SkuStockBatch(['sku.product']), function (Grid $grid) {
            $grid->model()->where('num', ">", 0);
            $grid->column('id')->sortable();
            $grid->column('sku.product.item_no', '产品编号');
            $grid->column('sku.product.name', '产品名称');
            $grid->column('sku.product.unit.name', '单位');
            $grid->column('sku.product.type_str', '类型');
            $grid->column('sku.attr_value_ids_str', '属性');
            $grid->column('percent', '含绒量(%)');
            $grid->column('standard_str', '检验标准');
            $grid->column('batch_no');
            $grid->column('num');
            $grid->column('cost_price', "成本价格");
            $grid->column("cost_price_total", "合计成本")->display(function () {
                return bcmul($this->num, $this->cost_price, 2);
            });
            $grid->column('position.name', '库位');

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
                $filter->like('batch_no', "批次号")->width(3);
                $filter->equal('position_id', "库位")->select(PositionModel::query()->latest()->pluck('name', 'id'))->width(3);
            });
            $grid->column("_id", "检验记录")->expand(ProductCheckDetails::make());
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($this->num > 0) {
                    $actions->append(new ProductCheck());
                }
                return $actions;
            });
            $grid->disableRowSelector();
            $grid->disableQuickEditButton();
            // $grid->disableActions();
            $grid->disableCreateButton();
        });
    }

    protected function iFrameGrid()
    {
        return Grid::make(new SkuStockBatch(['sku.product']), function (Grid $grid) {
            if (request()->get('table') === 'InventoryOrder') {
                $grid->model()->orderBy('id', 'desc');
            } else {
                $grid->model()->where([
                    'sku_id' => request()->input('sku_id'),
                    'standard' => request()->input('standard'),
                    'percent' => request()->input('percent'),
                ])->where('num', ">", 0)->orderBy('id', 'desc');
            }
            $grid->column('id')->sortable();
            $grid->column('sku.product.item_no', '产品编号');
            $grid->column('sku.product.name', '产品名称');
            $grid->column('sku.product.unit.name', '单位');
            $grid->column('sku.product.type_str', '类型');
            $grid->column('sku.attr_value_ids_str', '属性');
            $grid->column('standard', '检验标准');
            $grid->column('percent', '含绒量（%）');
            $grid->column('batch_no');
            $grid->column('num');
            $grid->column('position.name', '库位');

            $grid->filter(function (Grid\Filter $filter) {
            });
            $grid->tools(BatchStockSelectSave::make());
            $grid->disableActions();
            $grid->disableCreateButton();
        });
    }
}
