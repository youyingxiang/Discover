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

namespace App\Admin\Forms;

use App\Models\CheckProductModel;
use App\Models\SkuStockBatchModel;
use Dcat\Admin\Admin;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Form\Row;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ProductCheckForm extends Form implements LazyRenderable
{
    use LazyWidget;
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return Response
     */
    public function handle(array $input)
    {
        if ($input['num'] < 0) {
            return $this->error('批次库存数量不能小于0！');
        }
        DB::transaction(function () use ($input) {
            CheckProductModel::query()->create([
                'prev_sku_stock_batch_id' => $this->payload['id'],
                'standard' => $input['standard'],
                'carbon_fiber' => $input['carbon_fiber'],
                'percent' => $input['percent'],
                'raw_footage' => $input['raw_footage'],
                'velvet' => $input['velvet'],
                'magazine' => $input['magazine'],
                'fluffy_silk' => $input['fluffy_silk'],
                'terrestrial_feather' => $input['terrestrial_feather'],
                'feather_silk' => $input['feather_silk'],
                'heterochromatic_hair' => $input['heterochromatic_hair'],
                'flower_number' => $input['flower_number'],
                'blackhead' => $input['blackhead'],
                'cleanliness' => $input['cleanliness'],
                'moisture' => $input['moisture'],
                'bulkiness' => $input['bulkiness'],
                'odor' => $input['odor'],
                'duck_ratio' => $input['duck_ratio'],
                'user_id' => Admin::user()->id,
                'order_no' => $input['order_no'],
            ]);
        });

        return $this->success('添加检验成功！', route('sku-stock-batchs.index'));
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $sku_stock_batch_id = $this->payload['id'];
        $this->hidden('prev_sku_stock_batch_id')->value($sku_stock_batch_id);
        $skuStockBatch = SkuStockBatchModel::query()->findOrFail($sku_stock_batch_id);
        $this->hidden('num')->value($skuStockBatch->num);

        $this->row(function (Row $row) use ($skuStockBatch) {
            $row->width(4)->text('order_no', '订单号')->default(build_order_no('JY'))->readOnly();
            $row->width(4)->text('product_name', '产品名称')->value($skuStockBatch->sku->product->name)->readOnly();
            $row->width(4)->text('batch_no', '批次号')->value($skuStockBatch->batch_no)->readOnly();

//
        });
        $this->row(function (Row $row) use ($skuStockBatch) {
            $row->width(4)->text('product_att', '属性')->value($skuStockBatch->sku->attr_value_ids_str)->readOnly();
        });
        $this->row(function (Row $row) {
            $row->width(12)->html('<hr/><h3>成份分析明细</h3>');
        });
        $this->row(function (Row $row) use ($skuStockBatch) {
            $row->width(4)->select('standard', '检验标准')->options(SkuStockBatchModel::STANDARD)->default($skuStockBatch->standard);
            $row->width(4)->rate('percent', '含绒百分比')->default($skuStockBatch->percent);
            $row->width(4)->rate('carbon_fiber', '碳纤维')->default(0);
        });
        $this->row(function (Row $row) {
            $row->width(4)->rate('raw_footage', '毛片')->default(0);
            $row->width(4)->rate('velvet', '朵绒')->default(0);
            $row->width(4)->rate('magazine', '杂志')->default(0);
        });

        $this->row(function (Row $row) {
            $row->width(4)->rate('fluffy_silk', '绒丝')->default(0);
            $row->width(4)->rate('terrestrial_feather', '陆禽毛')->default(0);
            $row->width(4)->rate('feather_silk', '羽丝')->default(0);
        });
        $this->row(function (Row $row) {
            $row->width(4)->rate('heterochromatic_hair', '异色毛')->default(0);
            $row->width(4)->rate('flower_number', '朵数')->default(0);
            $row->width(4)->rate('blackhead', '黑头')->default(0);
        });
        $this->row(function (Row $row) {
            $row->width(4)->rate('cleanliness', '清洁度')->default(0);
            $row->width(4)->rate('moisture', '水份')->default(0);
            $row->width(4)->rate('bulkiness', '蓬松度')->default(0);
        });
        $this->row(function (Row $row) {
            $row->width(4)->rate('odor', '气味')->default(0);
            $row->width(4)->rate('duck_ratio', '鸭比')->default(0);
        });
    }
}
