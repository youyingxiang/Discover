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

namespace App\Admin\Actions\Grid;

use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\BatchAction;
use Illuminate\Http\Request;

class BatchOrderPrint extends BatchAction
{
    /**
     * @return string
     */
    protected $title = '单据打印';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $url = route('order.print', [
            'ids' => implode("-", $this->getKey()),
            'model' => $request->input('model'),
            'slug' => $request->input('slug'),
        ]);
        return $this->response()->script("window.open('{$url}')");
    }

    protected function parameters(): array
    {
        return [
            'model' => $this->getModel(),
            'slug' => admin_controller_slug(),
        ];
    }

    protected function html()
    {
        return <<<HTML
<a {$this->formatHtmlAttributes()}><button class="btn btn-primary btn-mini"><i class="feather icon-printer"></i> {$this->title()}</button></a>
HTML;
    }

    public function actionScript()
    {
        $warning = "请选择打印的单据！";

        return <<<JS
function (data, target, action) {
    var key = {$this->getSelectedKeysScript()}

    if (key.length === 0) {
        Dcat.warning('{$warning}');
        return false;
    }

    // 设置主键为复选框选中的行ID数组
    action.options.key = key;
}
JS;
    }

    public function getModel(): string
    {
        return admin_controller_name() . 'Model';
    }
}
