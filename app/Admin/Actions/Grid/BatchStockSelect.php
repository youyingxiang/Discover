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

use Dcat\Admin\Grid;
use Dcat\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Str;

class BatchStockSelect extends AbstractTool
{
    /**
     * @return string
     */
    protected $title = '选择批次';

    /**
     * @return string
     */
    public function html(): string
    {
        return <<<HTML
<span {$this->formatHtmlAttributes()} id="my-more-select-batch-resourc" href="javascript:void(0)"><button class="btn btn-primary dialog-create  btn-mini"><i
class="feather icon-plus"></i> {$this->title()}</button></span>
HTML;
    }

    public function script(): string
    {
        $url = route('sku-stock-batchs.index', [
            Grid::IFRAME_QUERY_NAME => 1,
            'sku_id'                => request()->input('sku_id'),
            'item_id'               => request()->input('item_id'),
            'table'                 => admin_controller_name(),
            'standard'              => request()->input('standard'),
            'percent'               => request()->input('percent'),
            'order_id'              => $this->getOrderId(),
        ]);
        return <<<JS
        $("#my-more-select-batch-resourc").on("click",function(){
            var url = "{$url}";
            layer.open({
                type: 2,
                area: ['70%', '90%'], //宽高
                content:url,
                end: function(){
                    Dcat.reload();
                }
            })
        });

JS;
    }

    public function getOrderId():int
    {
        return request()->route()->parameter($this->getTable()) ?? 0;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return Str::snake(admin_controller_name());
    }
}
