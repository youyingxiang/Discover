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

use App\Models\MakeProductOrderModel as Model;
use App\Models\TaskModel;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Collection;

class MakeProductOrder extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    public function getWithOrder(): Collection
    {
        return TaskModel::where('status', '!=', TaskModel::STATUS_FINISH)->orderBy('id', 'desc')->pluck('order_no', 'id');
    }
}
