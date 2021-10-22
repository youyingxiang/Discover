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
use Dcat\Admin\Grid\Displayers\AbstractDisplayer;

class BatchDeail extends AbstractDisplayer
{
    protected $selector = 'grid-filed-batch-detail';

    public function display($params = null)
    {
        if ($params instanceof \Closure) {
            $url = $params($this);
        } else {
            $url = $params;
        }
        $this->addScript();
        return "<a class='{$this->selector}' data-url='{$url}' href='javascript:void(0)' >详情</a>";
    }

    protected function addScript()
    {
        $script = <<<JS
            $(".{$this->selector}").on("click",function() {
                var url = $(this).attr('data-url');
                layer.open({
                    type: 2,
                    area: ['70%', '90%'], //宽高
                    content:url,
                    end: function(){
                        Dcat.reload();
                    }
                })
            })
JS;
        Admin::script($script);
    }
}
