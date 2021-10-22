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

class Delete extends BatchAction
{
    /**
     * @return string
     */
    protected $title = '删除';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $model      = $request->input('model');
        $modelClass = "\\App\Models\\" . $model;
        $keys       = $this->getKey();

        if (! class_exists($modelClass)) {
            throw new \Exception("参数错误！");
        }

        try {
            foreach ($keys as $key) {
                $modelClass::find($key)->delete();
            }
            return $this->response()->success("单据明细删除成功！")->refresh();
        } catch (\Exception $exception) {
            return $this->response()->error($exception->getMessage())->refresh();
        }
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return admin_controller_name() . 'Model';
    }

    /**
     * @return array
     */
    protected function parameters(): array
    {
        return [
            'model' => $this->getModel(),
        ];
    }

    public function actionScript()
    {
        $warning = "请选择删除的明细！";

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

    /**
     * @return array
     */
    public function confirm(): array
    {
        return ["确定删除明细?"];
    }

    /**
     * @return string
     */
    protected function html(): string
    {
        return <<<HTML
<a {$this->formatHtmlAttributes()}><button class="btn btn-primary btn-mini"><i class="feather icon-trash-2"></i> {$this->title()}</button></a>
HTML;
    }
}
