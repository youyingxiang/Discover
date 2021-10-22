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

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PrintController extends Controller
{
    public function print(Request $request)
    {
        $orderIds = explode("-", $request->input('ids'));
        $model = $request->input('model');
        /** @var Model $modelClass */
        $modelClass = "\\App\Models\\" . $model;
        $orders = $modelClass::query()->findOrFail($orderIds);
        $orderSlug = $request->input('slug');
        $orderField = collect(admin_trans($orderSlug.".fields"))->chunk(2)->toArray();

        $itemSlug = Str::replaceFirst("order", "item", $orderSlug);
        $itemField = admin_trans($itemSlug.".fields");
        $orderName = head(admin_trans($orderSlug . ".labels"));
        return view('print.print', compact("orders", 'orderField', 'itemField', 'orderName'));
    }
}
