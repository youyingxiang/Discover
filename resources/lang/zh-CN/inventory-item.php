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

return [
    'labels' => [
        'InventoryItem' => 'InventoryItem',
    ],
    'fields' => [
        'stock_batch.sku.product.name' => '产品名称',
        'stock_batch.sku.product.unit.name' => '单位',
        'stock_batch.sku.product.type_str' => '类型',
        'stock_batch.sku.attr_value_ids_str' => '属性',
        'stock_batch.percent' => '含绒量',
        'stock_batch.standard_str' => '检验标准',
        'cost_price' => '成本单价',
        'should_num' => '库存数量',
        'actual_num' => '实盘数量',
        'diff_num' => '盈亏数量',
        'diff_cost_price' => '盈亏金额',
        'stock_batch.batch_no' => '批次号',
    ],
    'options' => [
    ],
];
