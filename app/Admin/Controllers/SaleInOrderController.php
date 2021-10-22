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

use App\Admin\Actions\Grid\BatchOrderPrint;
use App\Admin\Repositories\SaleInOrder;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;

class SaleInOrderController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SaleInOrder(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('customer_id');
            $grid->column('finished_at');
            $grid->column('order_no');
            $grid->column('other');
            $grid->column('status');
            $grid->column('user_id');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->tools(BatchOrderPrint::make());

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
        return Form::make(new SaleInOrder(), function (Form $form) {
            $form->display('id');
            $form->text('customer_id');
            $form->text('finished_at');
            $form->text('order_no');
            $form->text('other');
            $form->text('status');
            $form->text('user_id');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
