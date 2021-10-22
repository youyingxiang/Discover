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

namespace App\Admin\Extensions\Form;

use Dcat\Admin\Form;
use Dcat\Admin\Admin;

class Select
{
    public static function macro(): void
    {
        static::loadpku();
        static::with_order();
    }

    protected static function with_order(): void
    {
        Form\Field\Select::macro('with_order', function () {
            $controller = admin_controller_name();
            $url = route('api.with.order');
            $script = <<<JS
$(document).off('change', "{$this->getElementClassSelector()}");
$(document).on('change', "{$this->getElementClassSelector()}", function () {
    
            if (String(this.value) !== '0' && ! this.value) {
                return;
            }
            var order_no = $('input[name="order_no"]').val();
            var with_order_id = this.value;
            var with_order_order = $(this).find('option:selected').text();
            
            
            data = {
                _token: Dcat.token,
                order_no: order_no,
                with_order_id: with_order_id,
                func: "{$controller}",
            }
            
            Dcat.confirm('确认关联单据'+with_order_order+'吗？', null, function () {
                Dcat.NP.start();
                $.ajax({
                        url: "{$url}",
                        type: "POST",
                        data: data,
                        success: function (data) {
                            if (data.code == 200) {
                                Dcat.success("订单关联成功！");
                                Dcat.reload();
                            } else {
                                Dcat.error(data.message);
                            }
                        },
                        error:function(a,b,c) {
                            Dcat.handleAjaxError(a, b, c);
                        },
                        complete:function(a,b) {
                            Dcat.NP.done();
                        }
                    });
                   
            });
});
JS;

            Admin::script($script);

            return $this;
        });
    }

    protected static function loadpku(): void
    {
        // 加载pku动态选择
        Form\Field\Select::macro('loadpku', function ($sourceUrl) {
            $sourceUrl  = admin_url($sourceUrl);
            $unitClass  = static::FIELD_CLASS_PREFIX . 'unit';
            $skuIdClass = static::FIELD_CLASS_PREFIX . 'sku_id';
            $typeClass  = static::FIELD_CLASS_PREFIX . 'type';

            $script = <<<JS
$(document).off('change', "{$this->getElementClassSelector()}");
$(document).on('change', "{$this->getElementClassSelector()}", function () {
     var unit = $(this).closest('.fields-group').find(".$unitClass");
     var sku_id = $(this).closest('.fields-group').find(".$skuIdClass");
     var type = $(this).closest('.fields-group').find(".$typeClass");
  

    if (String(this.value) !== '0' && ! this.value) {
        return;
    }
    
    $.ajax("$sourceUrl?q="+this.value).then(function (data) {
        unit.val(data.data.unit);
        type.val(data.data.type_str);
        sku_id.find("option").remove();
        
        $(sku_id).select2({
            data: $.map(data.data.product_attr, function (d) {
                d.id = d.id;
                d.text = d.text;
                return d;
            })
        }).val(sku_id.attr('data-value')).trigger('change');
    });
});
$("{$this->getElementClassSelector()}").trigger('change');
JS;

            Admin::script($script);

            return $this;
        });
    }
}
