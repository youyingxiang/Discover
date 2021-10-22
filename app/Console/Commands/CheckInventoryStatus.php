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

namespace App\Console\Commands;

use App\Models\InventoryModel;
use Illuminate\Console\Command;

class CheckInventoryStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:inventory-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检查盘点任务的状态';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        InventoryModel::query()
            ->where('status', "<", InventoryModel::STATUS_FINISH)
            ->get()
            ->each(function (InventoryModel $inventoryModel) {
                if (
                    $inventoryModel->status === InventoryModel::STATUS_NOT_STARTED
                    && now()->between($inventoryModel->start_at, $inventoryModel->end_at)
                ) {
                    $inventoryModel->status = InventoryModel::STATUS_WAIT;
                    $inventoryModel->saveOrFail();
                }

                if (
                    $inventoryModel->status === InventoryModel::STATUS_WAIT
                    && ! now()->between($inventoryModel->start_at, $inventoryModel->end_at)
                ) {
                    $inventoryModel->status = InventoryModel::STATUS_STOP;
                    $inventoryModel->saveOrFail();
                }
            });
    }
}
