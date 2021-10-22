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

namespace App\Repositories;

use App\Models\AttrValueModel;
use App\Traits\HasSelectLoadData;
use Yxx\LaravelQuick\Repositories\BaseRepository;

class AttrValueRepository extends BaseRepository
{
    use HasSelectLoadData;
    /**
     * @param int $attr_id
     * @return AttrValueRepository
     */
    public function getValueByAttrId(int $attr_id): self
    {
        $this->textid_array =  AttrValueModel::where('attr_id', $attr_id)->get();
        return $this;
    }
}
