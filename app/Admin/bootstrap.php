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

use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 */

Filter::resolving(function (Filter $filter) {
    $filter->panel();
    $filter->expand();
});

Grid::resolving(function (Grid $grid) {
    $grid->setActionClass(\Dcat\Admin\Grid\Displayers\Actions::class);
    $grid->model()->orderBy("id", "desc");
    $grid->disableViewButton();
    $grid->showQuickEditButton();
    $grid->enableDialogCreate();
    $grid->disableBatchDelete();
    $grid->actions(function (\Dcat\Admin\Grid\Displayers\Actions $actions) {
        $actions->disableView();
        $actions->disableDelete();
        $actions->disableEdit();
    });
    $grid->option("dialog_form_area", ["70%", "80%"]);
});

Form\Field::macro('enableHorizontal', function () {
    $this->horizontal = true;
    return $this;
});

\App\Admin\Extensions\Form\Select::macro();

Dcat\Admin\Grid\Column::extend('emp', \App\Admin\Extensions\Grid\EmptyData::class);
Dcat\Admin\Grid\Column::extend('fee', \App\Admin\Extensions\Grid\Fee::class);
Dcat\Admin\Grid\Column::extend('edit', \App\Admin\Extensions\Grid\Edit::class);
Dcat\Admin\Grid\Column::extend('selectplus', \App\Admin\Extensions\Grid\SelectPlus::class);
Dcat\Admin\Grid\Column::extend('batch_detail', \App\Admin\Extensions\Grid\BatchDeail::class);
Dcat\Admin\Form::extend('fee', \App\Admin\Extensions\Form\Fee::class);
Dcat\Admin\Form::extend('num', \App\Admin\Extensions\Form\Num::class);
Dcat\Admin\Form::extend('tableDecimal', \App\Admin\Extensions\Form\TableDecimal::class);
Dcat\Admin\Form::extend('ipt', \App\Admin\Extensions\Form\Input::class);
Dcat\Admin\Form::extend('reviewicon', \App\Admin\Extensions\Form\ReviewIcon::class);

$script = <<<'JS'
        $("#grid-table > tbody > tr").on("dblclick",function(event) {
           var obj = $(this).find(".feather.icon-edit");

           if (obj.attr('unique') == "true") {
               return
           }
           if (obj.length == 1) {
               obj.trigger("click")
               obj.attr('unique',true);
           }
        })
JS;
Admin::script($script);

app('view')->prependNamespace('admin', resource_path('views/vendor/laravel-admin'));
