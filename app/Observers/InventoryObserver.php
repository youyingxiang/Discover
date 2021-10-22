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

use App\Models\InventoryModel;
use Dcat\Admin\Admin;

class InventoryObserver
{
    public function creating(InventoryModel $inventoryModel)
    {
        $inventoryModel->user_id = Admin::user()->id;
        $inBetWeen = now()->between($inventoryModel->start_at, $inventoryModel->end_at);
        $inBetWeen && $inventoryModel->status = InventoryModel::STATUS_WAIT;
    }

    public function created(InventoryModel $inventoryModel)
    {
        $inventoryModel->order()->create([
            'order_no' => build_order_no('PD'),
            'user_id' => Admin::user()->id,
            'apply_id' => Admin::user()->id,
            'other' => '',
        ]);
    }

    public function deleting(InventoryModel $inventoryModel)
    {
        if ($inventoryModel->status >=InventoryModel::STATUS_FINISH) {
            throw new \Exception("当前盘点单据状态为".InventoryModel::STATUS[$inventoryModel->status]."无法删除！");
        }
        $inventoryModel->order->delete();
    }
}
