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

use App\Models\ApplyForOrderModel;
use App\Models\BaseModel;
use Dcat\Admin\Admin;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Table;

class ApplyOfOrders extends LazyRenderable
{
    public function render()
    {
        Admin::script($this->script());
        $id = $this->key;
        $applyForOrders =  ApplyForOrderModel::query()->where('with_id', $id)->latest()->get();
        $applyForOrders->transform(function (ApplyForOrderModel $applyForOrderModel, int $key) {
            $showBtn = $applyForOrderModel->review_status === BaseModel::REVIEW_STATUS_OK ? 'no' : 'yes';
            return [
                $key + 1,
                "<a class='edit-apply-of-order' data-show-btn='{$showBtn}' href='javascript:void(0)' data-action=".route('apply-for-orders.edit', $applyForOrderModel->id).">$applyForOrderModel->order_no</a>",
                ApplyForOrderModel::REVIEW_STATUS[$applyForOrderModel->review_status],
                $applyForOrderModel->created_at,
            ];
        });

        $titles = [
            '序号',
            '单号',
            '状态',
            '创建时间',
        ];
        return Table::make($titles, $applyForOrders->toArray());
    }

    public function script()
    {
        return <<<'JS'
        $(".edit-apply-of-order").on("click",function(){
            var action = $(this).data('action');
            var show_btn = $(this).data('show-btn');
            var option = {
                title:'物料申请单',
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
