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

use App\Models\CostOrderModel;
use App\Models\StatementItemModel;
use App\Models\StatementOrderModel;

class StatementOrderObserver
{
    public function deleting(StatementOrderModel $statementOrderModel)
    {
        if ($statementOrderModel->review_status === StatementOrderModel::REVIEW_STATUS_OK) {
            throw new \Exception("订单" . $statementOrderModel->order_no . "已经审核无法删除!");
        }
        $statementOrderModel->items()->delete();
    }

    public function saving(StatementOrderModel $statementOrderModel)
    {
        if ($statementOrderModel->isDirty('review_status') && (int)$statementOrderModel->review_status === StatementOrderModel::REVIEW_STATUS_OK) {
            $statementOrderModel->items->each(function (StatementItemModel $statementItemModel) {
                /** @var CostOrderModel $costOrder */
                $costOrder = $statementItemModel->cost_order;
                $costOrder->discount_amount = bcadd($costOrder->discount_amount, $statementItemModel->discount_amount, 5);
                $costOrder->settlement_amount = bcadd($costOrder->settlement_amount, $statementItemModel->actual_amount, 5);
                if (($costOrder->discount_amount + $costOrder->settlement_amount) >= $costOrder->total_amount) {
                    $costOrder->settlement_completed = CostOrderModel::SETTLEMENT_COMPLETEED;
                }
                $costOrder->saveOrFail();
            });
        }
    }
}
