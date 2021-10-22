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

use App\Admin\Repositories\SaleOutItem;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;

class SaleOutItemController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SaleOutItem(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('actual_num');
            $grid->column('order_id');
            $grid->column('price');
            $grid->column('should_num');
            $grid->column('sku_id');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new SaleOutItem(), function (Form $form) {
            $form->display('id');
            $form->text('actual_num');
            $form->text('order_id');
            $form->text('price');
            $form->text('should_num');
            $form->text('sku_id');
            $form->decimal('percent');
            $form->number('standard');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
