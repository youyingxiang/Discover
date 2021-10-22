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
use Dcat\Admin\Admin;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Table;

class CostDetail extends LazyRenderable
{
    public function render()
    {
        Admin::script($this->script());
        $data = CostItemModel::query()
            ->where('order_id', $this->key)
            ->get()
            ->transform(function (CostItemModel $item, int $key) {
                $showBtn = "no";
                $url = ($item->cost_type === CostItemModel::COST_TYPE_SALE) ? route('sale-out-orders.edit', $item->with_id) : route('purchase-in-orders.edit', $item->with_id);
                $title = ($item->cost_type === CostItemModel::COST_TYPE_SALE) ? '客户出货单' : '采购入库单';
                return [
                    "<a class='edit-cost-with-order' data-title='{$title}' data-show-btn='{$showBtn}' href='javascript:void(0)' data-action=".$url.">$item->with_order_no</a>",
                    $item->cost_type_str,
                    $item->should_amount,
                    $item->actual_amount,
                ];
            });
        $titles = [
            "业务单号",
            "费用类型",
            "费用金额",
            "实际金额",
        ];
        return Table::make($titles, $data->toArray());
    }
    public function script()
    {
        return <<<'JS'
        $(".edit-cost-with-order").on("click",function(){
            var action = $(this).data('action');
            var show_btn = $(this).data('show-btn');
            var title = $(this).data('title');
            var option = {
                title:title,
                type: 2,
                area: ['65%', '80%'], //宽高
                content:[action],
                scrollbar:false,
                // maxmin:true,
                end: function(){
                    if (show_btn == "yes") {
                        Dcat.reload();
                    }
                },
            };
            if (show_btn == 'yes') {
                option.btn = ['保存'];
                option.btn1 = function(index, layero){
                    var orderInfo = $('#layui-layer-iframe'+index).contents().find('.content .row:eq(0) .col-md-12:eq(0) form:eq(0)');
                    var url = orderInfo.attr('action');
                    Dcat.NP.start();
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: url ,//url
                        data: orderInfo.serialize(),
                        success: function (data) {
                            if (data.status) {
                                Dcat.success(data.message);
                            } else {
                                Dcat.error(data.message);
                            }
                        },
                        error : function(a,b,c) {
                            Dcat.handleAjaxError(a, b, c);
                        },
                        complete:function(a,b) {
                            Dcat.NP.done();
                        }
                    });
                    layer.close(index);
                };
            }
            layer.open(option)
        });
JS;
    }
}
