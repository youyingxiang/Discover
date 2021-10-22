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

use App\Models\BaseModel;
use App\Models\InventoryOrderModel;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;

class EditInventoryOrder extends RowAction
{
    /**
     * @return string
     */
    protected $title = '盘点单据';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function html()
    {
        $inventoryOrder = InventoryOrderModel::query()->where('with_id', $this->getKey())->firstOrFail();
        $url = route('inventory-orders.edit', $inventoryOrder->id);
        $showBtn = $inventoryOrder->review_status === BaseModel::REVIEW_STATUS_OK ? 'no' : 'yes';
        return <<<HTML
<a class="{$this->getElementClass()}" data-show-btn="{$showBtn}" href="javascript:void(0)" data-action="$url">{$this->title()}</a>
HTML;
    }

    public function script()
    {
        $class = $this->getElementClass();
        return <<<JS
        $(".{$class}").on("click",function(){
            var action = $(this).data('action');
            var show_btn = $(this).data('show-btn');
            var option = {
                title:'盘点单据',
                type: 2,
                area: ['65%', '80%'], //宽高
                content:[action],
                scrollbar:false,
                // maxmin:true,
                end: function(){
                    Dcat.reload();
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
