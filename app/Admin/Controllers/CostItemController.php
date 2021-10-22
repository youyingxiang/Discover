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

use App\Admin\Repositories\CostItem;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class CostItemController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new CostItem(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('order_id');
            $grid->column('cost_type');
            $grid->column('pay_type');
            $grid->column('should_amount');
            $grid->column('actual_amount');
            $grid->column('with_id');
            $grid->column('other');
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
        return Show::make($id, new CostItem(), function (Show $show) {
            $show->field('id');
            $show->field('order_id');
            $show->field('cost_type');
            $show->field('pay_type');
            $show->field('should_amount');
            $show->field('actual_amount');
            $show->field('with_id');
            $show->field('other');
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
        return Form::make(new CostItem(), function (Form $form) {
            $form->display('id');
            $form->text('order_id');
            $form->text('cost_type');
            $form->text('pay_type');
            $form->text('should_amount');
            $form->text('actual_amount');
            $form->text('with_id');
            $form->text('other')->saveAsString();

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
