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
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\Tools\AbstractTool;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BatchCreatePro extends AbstractTool
{
    /**
     * @return string
     */
    protected $title = '批量新增';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */

    public function html()
    {
        return <<<HTML
<span {$this->formatHtmlAttributes()} id="my-more-create-select-resourc" href="javascript:void(0)"><button class="btn btn-primary dialog-create  btn-mini"><i
class="feather icon-plus"></i> {$this->title()}</button></span>
HTML;
    }

    public function script()
    {
        $url = route('products.index', [
            Grid::IFRAME_QUERY_NAME => 1,
            'order_model' => $this->getModel(),
            'order_id' => $this->getOrderId(),
        ]);

        return <<<JS
        $("#my-more-create-select-resourc").on("click",function(){
            var url = "{$url}";
            layer.open({
                type: 2,
                area: ['70%', '90%'], //宽高
                content:[url,'no'],
                end: function(){
                    Dcat.reload();
                }
            })
        });

JS;
    }

    public function getModel(): string
    {
        return admin_controller_name() . 'Model';
    }

    public function getOrderId():int
    {
        return request()->route()->parameter($this->getTable());
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return Str::snake(admin_controller_name());
    }
}
