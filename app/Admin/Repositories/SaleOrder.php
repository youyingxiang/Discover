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

namespace App\Admin\Repositories;

use App\Models\CustomerModel;
use App\Models\SaleOrderModel as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Collection;

class SaleOrder extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    /**
     * @return Collection
     */
    public function customer(): Collection
    {
        return CustomerModel::OrderBy('id', 'desc')->pluck('name', 'id');
    }
}
