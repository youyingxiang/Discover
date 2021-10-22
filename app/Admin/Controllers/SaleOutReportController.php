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

use App\Admin\Extensions\Grid\SaleBatchDetail;
use App\Admin\Repositories\SaleOrderAmount;
use App\Admin\Repositories\SaleOutItem;
use App\Http\Controllers\Controller;
use App\Models\CustomerModel;
use App\Models\PurchaseInOrderModel;
use App\Models\SaleOrderAmountModel;
use App\Models\SaleOutOrderModel;
use App\Models\SupplierModel;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class SaleOutReportController extends Controller
{
    public function orderAmount(Content $content)
    {
        $grid = Grid::make(new SaleOrderAmount(['order', 'customer', 'accountant']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('order.order_no', "销售订单");
            $grid->column('customer.name', "客户名称");
            $grid->column('should_amount', '费用金额');
            $grid->column('actual_amount', '结算金额');
            $grid->column(
                'status',
                '状态'
            )->using(SaleOrderAmountModel::STATUS)->label(SaleOrderAmountModel::STATUS_COLOR);
            $grid->column('created_at');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('created_at', "时间")->datetime()->width(6)->default([
                    'start' => now()->subMonth(),
                    'end' => now()
                ]);
                $filter->in('customer_id', "客户名称")->width(4)->multipleSelect(CustomerModel::query()->pluck(
                    'name',
                    'id'
                ));
                $filter->equal('status', '状态')->width(4)->radio(SaleOrderAmountModel::STATUS);
            });
            $grid->disableCreateButton();
            $grid->export()->rows(function (array $rows) {
                return array_map(function ($row) {
                    return [
                        '销售订单' => $row['order']['order_no'],
                        '客户名称' => $row['customer']['name'],
                        '费用金额' => $row['should_amount'],
                        '结算金额' => $row['actual_amount'],
                        '状态' => SaleOrderAmountModel::STATUS[$row['status']],
                        '创建时间' => $row['created_at'],
                    ];
                }, $rows);
            })->extension("xlsx");
            $grid->disableActions();
        });

        return $content
            ->title("销售订单金额")
            ->description(' ')
            ->full()
            ->body($grid);
    }

    public function items(Content $content)
    {
        $grid = Grid::make(new SaleOutItem(['order', 'sku', 'order.customer', 'sku.product', 'batchs']), function (Grid $grid) {
            $grid->model()->resetOrderBy();
            $grid->model()->whereHas('order', function (Builder $builder) {
                $builder->where('review_status', SaleOutOrderModel::REVIEW_STATUS_OK);
            })->orderByDesc('order_id');
            $grid->column('order.order_no', '订单号');
            $grid->column('order.customer.name', '客户');
            $grid->column('sku.product.name', '产品名称');
            $grid->column('sku.product.unit.name', '单位');
            $grid->column('sku.product.type_str', '类型');
            $grid->column('sku.attr_value_ids_str', '属性');
            $grid->column('percent', '含绒百分比');
            $grid->column('standard_str', '检验标准');
            $grid->column('should_num', '要货数量')->sortable();
            $grid->column('actual_num', '销售数量')->sortable();
            $grid->column('price', '销售价格')->sortable();
            $grid->column('__', '出库批次详情')->expand(SaleBatchDetail::class);
            $grid->column("sum_price", '销售合计')->sortable();
            $grid->column("sum_cost_price", '成本合计')->sortable();
            $grid->column("profit", '利润')->sortable();
            $grid->column("order.apply_at", '时间')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('order.apply_at', "时间")->datetime()->width(6)->default([
                    'start' => now()->subMonth(),
                    'end' => now()
                ]);
                $filter->where("product_name", function (Builder $query) {
                    $query->whereHasIn("sku.product", function (Builder $query) {
                        $query->where(function (Builder $query) {
                            $query->orWhere("name", "like", $this->getValue()."%");
                            $query->orWhere("py_code", "like", $this->getValue()."%");
                            $query->orWhere('item_no', 'like', $this->getValue()."%");
                        });
                    });
                }, "关键字")->placeholder("产品名称，拼音码，编号")->width(3);
                $filter->equal('order.supplier_id', '供应商')->select(SupplierModel::query()->latest()->pluck('name', 'id'))->width(3);
                $filter->group('should_num', function ($group) {
                    $group->gt('大于');
                    $group->lt('小于');
                    $group->nlt('不小于');
                    $group->ngt('不大于');
                    $group->equal('等于');
                }, '要货数量')->width(3);
                $filter->group('actual_num', function ($group) {
                    $group->gt('大于');
                    $group->lt('小于');
                    $group->nlt('不小于');
                    $group->ngt('不大于');
                    $group->equal('等于');
                }, '销售数量')->width(3);
                $filter->like('percent', "含绒量")->decimal()->width(3);
                $filter->equal('standard', "检验标准")->select(PurchaseInOrderModel::STANDARD)->width(3);
            });

            $grid->export()->rows(function (array $rows) {
                return array_map(function ($row) {
                    return [
                        '订单号' => $row['order']['order_no'],
                        '客户' => $row['order']['customer']['name'],
                        '产品名称' => $row['sku']['product']['name'],
                        '单位' => $row['sku']['product']['unit']['name'],
                        '类型' => $row['sku']['product']['type_str'],
                        '属性' => $row['sku']['attr_value_ids_str'],
                        '含绒百分比' => $row['percent'],
                        '检验标准' => $row['standard_str'],
                        '要货数量' => $row['should_num'],
                        '销售数量' => $row['actual_num'],
                        '销售价格' => $row['price'],
                        '销售合计' => $row['sum_price'],
                        '成本合计' => $row['sum_cost_price'],
                        '利润' => $row['profit']
                    ];
                }, $rows);
            })->extension("xlsx");

            $grid->disableCreateButton();
            $grid->disableActions();
        });
        return $content
            ->title("销售成本毛利明细")
            ->description(' ')
            ->full()
            ->body($grid);
    }

    public function summaryByCustomer(Content $content)
    {
        $grid = Grid::make(new SaleOutItem(['sku', 'sku.product']), function (Grid $grid) {
            $grid->model()->resetOrderBy();
            $grid->model()
                ->select([
                    'sale_out_order.customer_id as customer_id',
                    'sale_out_item.sku_id as sku_id',
                    'sale_out_item.standard as standard',
                    'sale_out_item.percent as percent',
                    DB::raw('sum(sale_out_item.should_num) as sum_should_num'),
                    DB::raw('sum(sale_out_item.actual_num) as sum_actual_num'),
                    DB::raw('sum(sale_out_item.sum_cost_price) as sum_cost_price'),
                    DB::raw('sum(sale_out_item.sum_price) as sum_price'),
                    DB::raw('sum(sale_out_item.profit) as sum_profit'),
                ])
                ->leftJoin('sale_out_order', 'sale_out_item.order_id', '=', 'sale_out_order.id')
                ->where('sale_out_order.review_status', SaleOutOrderModel::REVIEW_STATUS_OK)
                ->groupBy(
                    'sale_out_order.customer_id',
                    'sale_out_item.sku_id',
                    'sale_out_item.standard',
                    'sale_out_item.percent'
                );

            $grid->column('customer_id', '客户')->display(function ($val) {
                return CustomerModel::query()->where('id', $val)->value('name');
            })->sortable();
            $grid->column('sku.product.name', '产品名称');
            $grid->column('sku.product.unit.name', '单位');
            $grid->column('sku.product.type_str', '类型');
            $grid->column('sku.attr_value_ids_str', '属性');
            $grid->column('percent', '含绒百分比');
            $grid->column('standard_str', '检验标准');
            $grid->column('sum_should_num', '要货数量')->sortable();
            $grid->column('sum_actual_num', '出库数量')->sortable();
            $grid->column('sum_cost_price', '成本价格')->sortable();
            $grid->column('sum_price', '销售价格')->sortable();
            $grid->column('sum_profit', '利润')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('order.apply_at', "时间")->datetime()->width(6)->default([
                    'start' => now()->subMonth(),
                    'end' => now()
                ]);
                $filter->where("product_name", function (Builder $query) {
                    $query->whereHasIn("sku.product", function (Builder $query) {
                        $query->where(function (Builder $query) {
                            $query->orWhere("name", "like", $this->getValue()."%");
                            $query->orWhere("py_code", "like", $this->getValue()."%");
                            $query->orWhere('item_no', 'like', $this->getValue()."%");
                        });
                    });
                }, "关键字")->placeholder("产品名称，拼音码，编号")->width(3);
                $filter->equal('customer_id', '客户')->select(CustomerModel::query()->latest()->pluck('name', 'id'))->width(3);
                $filter->like('percent', "含绒量")->decimal()->width(3);
                $filter->equal('standard', "检验标准")->select(SaleOutOrderModel::STANDARD)->width(3);
            });

            $grid->export()->rows(function (array $rows) {
                return array_map(function ($row) {
                    return [
                        '客户' => CustomerModel::query()->where('id', $row['customer_id'])->value('name'),
                        '产品名称' => $row['sku']['product']['name'],
                        '单位' => $row['sku']['product']['unit']['name'],
                        '类型' => $row['sku']['product']['type_str'],
                        '属性' => $row['sku']['attr_value_ids_str'],
                        '含绒百分比' => $row['percent'],
                        '检验标准' => $row['standard_str'],
                        '要货数量' => $row['sum_should_num'],
                        '出库数量' => $row['sum_actual_num'],
                        '成本价格' => $row['sum_cost_price'],
                        '销售价格' => $row['sum_price'],
                        '利润' => $row['sum_profit'],
                    ];
                }, $rows);
            })->extension("xlsx");

            $grid->disableActions();
            $grid->disableCreateButton();
        });
        return $content
            ->title("销售出库汇总(客户)")
            ->description(' ')
            ->full()
            ->body($grid);
    }

    public function summaryBySku(Content $content)
    {
        $grid = Grid::make(new SaleOutItem(['order', 'sku', 'sku.product']), function (Grid $grid) {
            $grid->model()->resetOrderBy();
            $grid->model()->select(
                'sku_id',
                'standard',
                'percent',
                DB::raw('sum(should_num) as sum_should_num'),
                DB::raw('sum(actual_num) as sum_actual_num'),
                DB::raw('sum(sum_cost_price) as sum_cost_price'),
                DB::raw('sum(sum_price) as sum_price'),
                DB::raw('sum(profit) as sum_profit')
            )->whereHas('order', function (Builder $builder) {
                $builder->where('review_status', SaleOutOrderModel::REVIEW_STATUS_OK);
            })->groupBy(
                'sku_id',
                'percent',
                'standard'
            );
            $grid->column('sku.product.name', '产品名称');
            $grid->column('sku.product.unit.name', '单位');
            $grid->column('sku.product.type_str', '类型');
            $grid->column('sku.attr_value_ids_str', '属性');
            $grid->column('percent', '含绒百分比');
            $grid->column('standard_str', '检验标准');
            $grid->column('sum_should_num', '要货数量')->sortable();
            $grid->column('sum_actual_num', '出库数量')->sortable();
            $grid->column('sum_cost_price', '成本价格')->sortable();
            $grid->column('sum_price', '销售价格')->sortable();
            $grid->column('sum_profit', '利润')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('order.apply_at', "时间")->datetime()->width(6)->default([
                    'start' => now()->subMonth(),
                    'end' => now()
                ]);
                $filter->where("product_name", function (Builder $query) {
                    $query->whereHasIn("sku.product", function (Builder $query) {
                        $query->where(function (Builder $query) {
                            $query->orWhere("name", "like", $this->getValue()."%");
                            $query->orWhere("py_code", "like", $this->getValue()."%");
                            $query->orWhere('item_no', 'like', $this->getValue()."%");
                        });
                    });
                }, "关键字")->placeholder("产品名称，拼音码，编号")->width(3);

                $filter->like('percent', "含绒量")->decimal()->width(3);
                $filter->equal('standard', "检验标准")->select(SaleOutOrderModel::STANDARD)->width(3);
            });

            $grid->export()->rows(function (array $rows) {
                return array_map(function ($row) {
                    return [
                        '产品名称' => $row['sku']['product']['name'],
                        '单位' => $row['sku']['product']['unit']['name'],
                        '类型' => $row['sku']['product']['type_str'],
                        '属性' => $row['sku']['attr_value_ids_str'],
                        '含绒百分比' => $row['percent'],
                        '检验标准' => $row['standard_str'],
                        '要货数量' => $row['sum_should_num'],
                        '出库数量' => $row['sum_actual_num'],
                        '成本价格' => $row['sum_cost_price'],
                        '销售价格' => $row['sum_price'],
                        '利润' => $row['sum_profit'],
                    ];
                }, $rows);
            })->extension("xlsx");

            $grid->disableCreateButton();
            $grid->disableActions();
        });
        return $content
            ->title("销售出库汇总(产品)")
            ->description(' ')
            ->full()
            ->body($grid);
    }
}
