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

use App\Models\AttrValueModel;
use App\Models\BaseModel;
use App\Models\OrderNoGeneratorModel;

if (! file_exists("lower_pinyin_abbr")) {
    /**
     * @param string $str
     *
     * @return string
     */
    function up_pinyin_abbr(string $str): string
    {
        return strtoupper(pinyin_abbr($str));
    }
}

if (! function_exists('build_order_no')) {
    /**
     * @param string $prefix
     * @return string
     */
    function build_order_no(string $prefix = ''): string
    {
        $date = date("Ymd");
        $number = OrderNoGeneratorModel::query()->where([
            'prefix' => $prefix,
            'happen_date' => $date
        ])->value('number');

        return $prefix . $date . str_pad($number + 1, "4", "0", STR_PAD_LEFT);
    }
}
if (! function_exists('crossJoin')) {
    /**
     * @param $arrays
     * @return array
     */
    function crossJoin($arrays)
    {
        $results = [[]];

        foreach ($arrays as $index => $array) {
            $append = [];

            foreach ($results as $product) {
                foreach ($array as $item) {
                    $product[$index] = $item;

                    $append[] = $product;
                }
            }

            $results = $append;
        }

        return $results;
    }
}

if (! function_exists('attrCrossJoin')) {
    function attrCrossJoin($arrays)
    {
        $result = [];
        $attr_values = AttrValueModel::getAttrValues();
        array_map(function (array $value) use (&$result,$attr_values) {
            $key          = implode(',', $value);
            $str          = $attr_values->only($value);
            $result[$key] = $str;
        }, crossJoin($arrays));
        return $result;
    }
}
if (! function_exists('show_order_review')) {
    function show_order_review(int $review_status): int
    {
        if (in_array($review_status, [BaseModel::REVIEW_STATUS_WAIT, BaseModel::REVIEW_STATUS_REREVIEW])) {
            return BaseModel::REVIEW_STATUS_OK;
        }
        return BaseModel::REVIEW_STATUS_REREVIEW;
    }
}

if (! file_exists("store_order_img")) {
    /**
     * @param int $status
     *
     * @return string
     */
    function store_order_img(string $status): string
    {
        $img = "";
        switch ($status) {
            case BaseModel::REVIEW_STATUS_WAIT:
                $img = asset("static/images/stamp_0002.png");
                break;
            case BaseModel::REVIEW_STATUS_OK:
                $img = asset("static/images/stamp_0003.png");
                break;
            case BaseModel::REVIEW_STATUS_REREVIEW:
                $img = asset("static/images/stamp_0004.png");
                break;
        }
        return $img;
    }
}
