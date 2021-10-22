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

class Edit extends AbstractDisplayer
{
    protected $selector = 'grid-filed-editor';

    public function display($refresh = true)
    {
        $this->addStyle();
        $this->addScript();

        return <<<HTML
    <span
    class="{$this->selector}"
    data-value="{$this->value}"
    data-name="{$this->column->getName()}"
    data-refresh="{$refresh}"
    data-id="{$this->getKey()}"
    data-url="{$this->getUrl()}" >
    {$this->value}
    </span>
HTML;
    }

    protected function getUrl()
    {
        return $this->resource() . '/' . $this->getKey();
    }

    protected function addStyle()
    {
        $color = Admin::color()->link();

        Admin::style(
            <<<CSS
.grid-filed-editor{border-bottom:dashed 1px $color;color: $color;display: inline-block}
CSS
        );
    }

    protected function addScript()
    {
        $script = <<<JS
            $(".{$this->selector}").on("click",function() {
                if ($(this).attr('contenteditable') == 'true') {
                    return
                }
                $(this).attr('contenteditable', true);
                $(this).width($(this).width()+50);
            })
            $(".{$this->selector}").on("blur",function() {
                var obj = $(this),
                    url = obj.attr('data-url').trim(),
                    name = obj.attr('data-name').trim(),
                    refresh = obj.attr('data-refresh').trim(),
                    old_value = obj.attr('data-value').trim(),
                    value = obj.html().replace(new RegExp("<br>","g"), '').replace(new RegExp("&nbsp;","g"), '').trim();

                if (value != old_value) {
                    var data = {
                        _token: Dcat.token,
                        _method: 'PUT'
                    };
                    data[name] = value;
                    Dcat.NP.start();
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: data,
                        success: function (data) {
                            Dcat.NP.done();
                            if (data.status) {
                                obj.attr('data-value',value)
                                obj.attr('contenteditable', false);
                                Dcat.success(data.message);
                                refresh && Dcat.reload()
                            } else {
                                obj.html(old_value)
                                Dcat.error(data.message);
                            }
                        },
                        error:function(a,b,c) {
                          Dcat.NP.done();
                          obj.html(old_value)
                          Dcat.handleAjaxError(a, b, c);
                        }
                    });
                }
            })
JS;
        Admin::script($script);
    }
}
