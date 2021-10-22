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

use App\Admin\Extensions\Expand\AttrValue;
use App\Admin\Repositories\Attr;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;

class AttrController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Attr(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('value', '属性值')
                ->display('查看')
                ->expand(AttrValue::class);
            $grid->column('created_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Attr('values'), function (Form $form) {
            $form->text('name')->help('例如：颜色，尺寸')->required();
            $form->hasMany('values', '属性值', function (Form\NestedForm $table) {
                $table->text('name', '名称')->help('属性的值（例如颜色的值：黄色，蓝色）');
            })->useTable();
        });
    }
}
