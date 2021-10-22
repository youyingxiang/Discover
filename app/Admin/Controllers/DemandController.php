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

use App\Admin\Repositories\Demand;
use App\Models\DemandModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;

class DemandController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Demand(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('status')->using(DemandModel::STATUS)->label(DemandModel::STATUS_COLOR);
            $grid->column('type')->using(DemandModel::TYPE)->label(DemandModel::TYPE_COLOR);
            $grid->column('created_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Demand(), function (Form $form) {
            $form->markdown('content');
            $form->radio('type')->options(DemandModel::TYPE)->default(0);
            $form->markdown('reply');
            $form->select('status')->options(DemandModel::STATUS)->default(0);
        });
    }
}
