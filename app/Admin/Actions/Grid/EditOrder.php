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
use Dcat\Admin\Grid\RowAction;

class EditOrder extends RowAction
{
    public function id()
    {
        return "row-edit-select-resourc{$this->getKey()}";
    }

    public function render()
    {
        parent::render();
        return <<<HTML
<span class="grid-expand">
   <a href="javascript:void(0)" id="{$this->id()}"><i class="feather icon-edit grid-action-icon"></i></a>
</span>
HTML;
    }

    /**
     * @return string
     */
    public function action()
    {
        return $this->resource() . "/" . $this->getKey() . "/edit";
    }

    public function script()
    {
        $showBtn = $this->row('review_status') === BaseModel::REVIEW_STATUS_OK ? 'no' : 'yes';
        $lable   = admin_trans_label();
        return <<<JS
        $("#{$this->id()}").on("click",function(){
            var show_btn = '{$showBtn}';
            var option = {
                title:'$lable',
                type: 2,
                area: ['65%', '80%'], //宽高
                content:["{$this->action()}"],
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
                
        })
JS;
    }
}
