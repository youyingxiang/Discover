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

use App\Models\AccountantDateItemModel;
use App\Models\CostOrderModel as Model;
use Carbon\Carbon;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Collection;

class CostOrder extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    public function getYearMonth():Collection
    {
        return AccountantDateItemModel::query()->latest()->get()
            ->filter(function (AccountantDateItemModel $itemModel) {
                return Carbon::create($itemModel->accountant_date->year, $itemModel->month)->startOfMonth() < now()->startOfMonth();
            })->map(function (AccountantDateItemModel $itemModel) {
                return [
                    'yearmonth' => $itemModel->year_month,
                    'id' => $itemModel->id,
                ];
            })->sortByDesc('yearmonth')->pluck('yearmonth', 'id');
    }
}
