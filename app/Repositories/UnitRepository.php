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

use App\Models\ProductModel;
use App\Models\UnitModel;
use App\Traits\HasSelectLoadData;
use Illuminate\Support\Collection;
use Yxx\LaravelQuick\Repositories\BaseRepository;

class UnitRepository extends BaseRepository
{
    use HasSelectLoadData;

    /**
     * @param string $column
     * @param string $key
     * @return Collection
     */
    public static function pluck(string $column, string $key): Collection
    {
        $result = UnitModel::pluck($column, $key);
        return $result->isEmpty() ? collect([0 => '暂无单位']) : $result;
    }

    /**
     * @param int $product_id
     * @return UnitRepository
     */
    public function getUnitByProductId(int $product_id): self
    {
        $product = ProductModel::findOrFail($product_id);
        $this->textid_array = collect([$product->unit->toArray()]);
        return $this;
    }
}
