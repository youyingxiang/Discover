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

use Dcat\Admin\Admin;
use Dcat\Admin\Form\Field;

class ReviewIcon extends Field
{
    public function render()
    {
        $show_status_img = store_order_img($this->value);

        if ($show_status_img) {
            Admin::style($this->style());
            return "<i data-column='{$this->column}' data-value='{$this->value}' class=\"postImg\"><img src=\"{$show_status_img}\"></i>";
        }
    }

    public function style()
    {
        return <<<'CSS'
        .postImg{
            width: 160px;
            height: 100px;
            position: absolute;
            right: 115px;
            top: -8rem;
            z-index: 999;
        }
        .postImg img{
            width: 100%;
        }
CSS;
    }
}
