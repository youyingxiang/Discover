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

namespace App\Http\Resources;

use App\Models\AttrValueModel;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttrResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'attr_id' => $this->attr_id,
            //            'attr_name' => $this->attr->name ?? '',
            'value'   => array_map(function (int $id) {
                return ['id' => $id, 'text' => AttrValueModel::whereId($id)->value('name')];
            }, $this->attr_value_ids),
        ];
    }
}
