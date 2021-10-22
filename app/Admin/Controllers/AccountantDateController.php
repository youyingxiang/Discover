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

use App\Admin\Extensions\Grid\AccountantDateItems;
use App\Admin\Repositories\AccountantDate;
use App\Models\AccountantDateModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;

class AccountantDateController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AccountantDate(), function (Grid $grid) {
            $grid->model()->resetOrderBy();
            $grid->model()->orderBy('year', 'desc');
            $grid->column('year')->sortable();
            $grid->column('day')->display(function () {
                return $this->day_type === AccountantDateModel::DEFAULT ? "自然日" : $this->day;
            });
            $grid->column('_id', "会计期")->expand(AccountantDateItems::make());
            $grid->column('created_at');
            $grid->showBatchDelete();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new AccountantDate(), function (Form $form) {
            $year = AccountantDateModel::query()->latest()->value('year');
            $form->year('year')
                ->creationRules(['unique:accountant_date'], ['unique' => '您的会计年度已经存在，会计年份不可以建立，请核对！'])
                ->updateRules(['unique:accountant_date,year,{{id}}'], ['unique' => '您的会计年度已经存在，会计年份不可以建立，请核对！'])
                ->default($year ? $year + 1 : now()->year)
                ->required();
            $form->select("day_type", "结算日期")->options(AccountantDateModel::TYPE)->when(AccountantDateModel::CUSTOMIZE, function (
                Form $form
            ) {
                $form->number('day')->rules("gt:0|lt:29", ['gt' => '最小值1', 'lt' => '最大值28'])
                    ->default(28)
                    ->required();
            })->default(AccountantDateModel::DEFAULT);
        });
    }
}
