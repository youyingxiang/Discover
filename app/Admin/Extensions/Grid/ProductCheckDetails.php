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

namespace App\Admin\Extensions\Grid;

use App\Models\CheckProductModel;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Table;

class ProductCheckDetails extends LazyRenderable
{
    public function render()
    {
        $id = $this->key;
        $checkProductDetails = CheckProductModel::query()->where('sku_stock_batch_id', $id)->orderBy('id', 'desc')->get();

        $checkProductDetails->transform(function (CheckProductModel $model, $key) {
            return [
                $key + 1,
                $model->standard_str,
                $model->percent,
                $model->user->name,
                $model->carbon_fiber,
                $model->raw_footage,
                $model->velvet,
                $model->magazine,
                $model->fluffy_silk,
                $model->terrestrial_feather,
                $model->feather_silk,
                $model->heterochromatic_hair,
                $model->flower_number,
                $model->blackhead,
                $model->cleanliness,
                $model->moisture,
                $model->bulkiness,
                $model->odor,
                $model->duck_ratio,
            ];
        });
        $titles = [
            '序号',
            '检验标准',
            '含绒量（%）',
            '质检员',
            '碳纤维',
            '毛片',
            '朵绒',
            '杂志',
            '绒丝',
            '陆禽毛',
            '羽丝',
            '异色毛',
            '朵数',
            '黑头',
            '清洁度',
            '水份',
            '蓬松度',
            '气味',
            '鸭比',
        ];

        return Table::make($titles, $checkProductDetails->toArray());
    }
}
