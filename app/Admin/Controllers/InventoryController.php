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

use App\Admin\Actions\Grid\Delete;
use App\Admin\Actions\Grid\EditInventoryOrder;
use App\Admin\Repositories\Inventory;
use App\Models\InventoryModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;

class InventoryController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Inventory('user'), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('order_no');
            $grid->column('start_at');
            $grid->column('end_at');
            $grid->column('status', '状态')->using(InventoryModel::STATUS)->label(InventoryModel::STATUS_COLOR);
            $grid->column('user.name', "创建人");
            $grid->column('other');
            $grid->disableQuickEditButton();
            $grid->showBatchDelete();
            $grid->actions(function (\Dcat\Admin\Grid\Displayers\Actions $actions) {
                if ($this->status !== InventoryModel::STATUS_NOT_STARTED) {
                    $actions->append(new EditInventoryOrder());
                }
            });
            $grid->tools(Delete::make());
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Inventory(), function (Form $form) {
            $form->text('order_no', "盘点任务号")->default(build_order_no("PDRW"))->readOnly();
            $form->datetimeRange('start_at', 'end_at', '盘点启止时间')->required();
            $form->text('other')->saveAsString();
        });
    }
}
