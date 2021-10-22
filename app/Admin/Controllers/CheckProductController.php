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

use App\Admin\Repositories\CheckProduct;
use App\Models\ProductModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class CheckProductController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new CheckProduct(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('check_no');
            $grid->column('num');
            $grid->column('carbon_fiber');
            $grid->column('cashmere_content');
            $grid->column('raw_footage');
            $grid->column('velvet');
            $grid->column('magazine');
            $grid->column('fluffy_silk');
            $grid->column('terrestrial_feather');
            $grid->column('feather_silk');
            $grid->column('heterochromatic_hair');
            $grid->column('flower_number');
            $grid->column('blackhead');
            $grid->column('cleanliness');
            $grid->column('moisture');
            $grid->column('bulkiness');
            $grid->column('odor');
            $grid->column('duck_ratio');
            $grid->column('user_id');
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
        return Show::make($id, new CheckProduct(), function (Show $show) {
            $show->field('id');
            $show->field('check_no');
            $show->field('num');
            $show->field('carbon_fiber');
            $show->field('cashmere_content');
            $show->field('raw_footage');
            $show->field('velvet');
            $show->field('magazine');
            $show->field('fluffy_silk');
            $show->field('terrestrial_feather');
            $show->field('feather_silk');
            $show->field('heterochromatic_hair');
            $show->field('flower_number');
            $show->field('blackhead');
            $show->field('cleanliness');
            $show->field('moisture');
            $show->field('bulkiness');
            $show->field('odor');
            $show->field('duck_ratio');
            $show->field('user_id');
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
        return Form::make(new CheckProduct(), function (Form $form) {
            $form->row(function (Form\Row $row) {
                $row->width(12)->html('<h1 align="center">产品检验单</h1>');
            });

            $form->row(function (Form\Row $row) {
                $row->width(3)->text('check_no')->default(build_order_no('JY'))->readOnly();
                $row->width(3)->select('product_id', '产品')->options(ProductModel::pluck('name', 'id'))->loadpku(route('api.product.find'))->required();
                $row->width(3)->select('sku_id', '属性选择')->options()->required();
                $row->width(3)->number('num')->default(0)->required();
            });
            $form->row(function (Form\Row $row) {
                $row->width(12)->html('<hr/><h3>成份分析明细</h3>');
            });
            $form->row(function (Form\Row $row) {
                $row->width(3)->rate('carbon_fiber')->default(0);
                $row->width(3)->rate('cashmere_content')->default(0)->required();
                $row->width(3)->rate('raw_footage')->default(0);
                $row->width(3)->rate('velvet')->default(0);
            });

            $form->row(function (Form\Row $row) {
                $row->width(3)->rate('magazine')->default(0);
                $row->width(3)->rate('fluffy_silk')->default(0);
                $row->width(3)->rate('terrestrial_feather')->default(0);
                $row->width(3)->rate('feather_silk')->default(0);
            });
            $form->row(function (Form\Row $row) {
                $row->width(3)->rate('heterochromatic_hair')->default(0);
                $row->width(3)->rate('flower_number')->default(0);
                $row->width(3)->rate('blackhead')->default(0);
                $row->width(3)->rate('cleanliness')->default(0);
            });
            $form->row(function (Form\Row $row) {
                $row->width(3)->rate('moisture')->default(0);
                $row->width(3)->rate('bulkiness')->default(0);
                $row->width(3)->rate('odor')->default(0);
                $row->width(3)->rate('duck_ratio')->default(0);
            });
        });
    }
}
