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

use App\Admin\Repositories\StatementItem;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class StatementItemController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new StatementItem(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('order_id');
            $grid->column('statement_order_id');
            $grid->column('order_amount');
            $grid->column('should_amount');
            $grid->column('actual_amount');
            $grid->column('discount_amount');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new StatementItem(), function (Show $show) {
            $show->field('id');
            $show->field('order_id');
            $show->field('statement_order_id');
            $show->field('order_amount');
            $show->field('should_amount');
            $show->field('actual_amount');
            $show->field('discount_amount');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new StatementItem(), function (Form $form) {
            $form->display('id');
            $form->text('order_id');
            $form->text('statement_order_id');
            $form->text('order_amount');
            $form->text('should_amount');
            $form->decimal('actual_amount', "本次付款金额")->default(0)->required();
            $form->decimal('discount_amount', "本次优惠金额")->default(0)->required();

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
