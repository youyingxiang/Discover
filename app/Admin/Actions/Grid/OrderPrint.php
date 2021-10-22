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
use Dcat\Admin\Grid\Tools\AbstractTool;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderPrint extends AbstractTool
{
    /**
     * @return string
     */
    protected $title = '打印';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $url = $request->input('url');
        return $this->response()->script("window.open('{$url}')");
    }

    public function html()
    {
        return <<<HTML
<a {$this->formatHtmlAttributes()}><button id="order_print" class="btn btn-primary btn-mini"><i class="feather icon-printer"></i> {$this->title()}</button></a>
HTML;
    }

    protected function parameters(): array
    {
        return [
            'url'           => route('order.print', [
                'ids' => $this->getOrderId(),
                'model' => $this->getModel(),
                'slug' => admin_controller_slug(),
            ]),
        ];
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return Str::snake(admin_controller_name());
    }

    public function getModel(): string
    {
        return admin_controller_name() . 'Model';
    }

    public function getOrderId():int
    {
        return request()->route()->parameter($this->getTable());
    }
}
