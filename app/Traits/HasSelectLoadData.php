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

namespace App\Traits;

trait HasSelectLoadData
{
    /**
     * @var
     */
    protected $textid_array;

    /**
     * @param string $id
     * @param string $text
     * @return array
     */
    public function textIdtoArray(string $id, string $text):array
    {
        return $this->textid_array->map(function ($data) use ($id, $text) {
            return [
                'id'   => $data[$id],
                'text' => $data[$text],
            ];
        })->toArray();
    }
}
