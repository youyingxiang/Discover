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

namespace App\Http\Requests;

class WithOrderRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'order_no'      => 'string|required',
            'func'          => 'string|required',
            'with_order_id' => 'integer|required|gt:0',
        ];
    }

    public function validated(): array
    {
        return $this->validator->validated();
    }
}
