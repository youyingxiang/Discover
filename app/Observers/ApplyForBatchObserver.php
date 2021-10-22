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

namespace App\Observers;

use App\Models\ApplyForBatchModel;
use App\Models\ApplyForItemModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ApplyForBatchObserver
{
    protected function updateItemActual(ApplyForBatchModel $applyForBatchModel): void
    {
        $applyForBatchs = ApplyForBatchModel::where(function (Builder $query) use ($applyForBatchModel) {
            $query->where("item_id", $applyForBatchModel->item_id);
        })->get(['actual_num', 'stock_batch_id']);
        /** @var Collection $applyForBatchs */
        $costPrice = $applyForBatchs->reduce(function (?float $costPrice, ApplyForBatchModel $applyForBatchModel) {
            $costPrice =  bcadd($costPrice ?? 0, bcmul($applyForBatchModel->actual_num, $applyForBatchModel->stock_batch->cost_price, 5), 5);
            return $costPrice;
        });
        ApplyForItemModel::query()->whereId($applyForBatchModel->item_id)->update(["actual_num" =>$applyForBatchs->sum('actual_num'), 'cost_price' => $costPrice]);
    }

    public function deleted(ApplyForBatchModel $applyForBatchModel): void
    {
        $this->updateItemActual($applyForBatchModel);
    }

    public function saved(ApplyForBatchModel $applyForBatchModel): void
    {
        $this->updateItemActual($applyForBatchModel);
    }
}
