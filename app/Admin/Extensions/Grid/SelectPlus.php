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

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Displayers\Select;

class SelectPlus extends Select
{
    protected function addScript($refresh)
    {
        $script = <<<JS
$('.{$this->selector}').off('change').select2().on('change', function(){
    var value = $(this).val(),
        name = $(this).data('name'),
        url = $(this).data('url'),
        data = {
            _token: Dcat.token,
            _method: 'PUT'
        },
        reload = '{$refresh}';
    
    if (name.indexOf('.') === -1) {
        data[name] = value;
    } else {
        name = name.split('.');
        
        data[name[0]] = {};
        data[name[0]][name[1]] = value;
    }
    
    Dcat.NP.start();
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        success: function (data) {
            Dcat.NP.done();
            Dcat.success(data.message);
            Dcat.reload();
        }
    });
});
JS;

        Admin::script($script);
    }
}
