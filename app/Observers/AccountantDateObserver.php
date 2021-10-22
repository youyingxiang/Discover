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

use App\Models\AccountantDateModel;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;

class AccountantDateObserver
{
    public function saved(AccountantDateModel $accountantDateModel)
    {
        $start = Carbon::create($accountantDateModel->year)->startOfYear();
        $end = Carbon::create($accountantDateModel->year)->endOfYear();
        $items = [];

        if ((int)$accountantDateModel->day_type === AccountantDateModel::DEFAULT) {
            CarbonPeriod::create($start, '1 month', $end)->forEach(function (Carbon $carbon) use (&$items) {
                $items[] = [
                    'start_at' => $carbon->toDateTimeImmutable(),
                    'end_at' => $carbon->endOfMonth()->toDateTimeImmutable(),
                    'month' => $carbon->month
                ];
            });
        } elseif ((int)$accountantDateModel->day_type === AccountantDateModel::CUSTOMIZE) {
            array_reduce(CarbonPeriod::create($start, '1 month', $end)->toArray(), function (?\DateTimeImmutable $start, Carbon $carbon) use (&$items, $accountantDateModel) {
                $start = $start ? CarbonImmutable::parse($start)->addSeconds(1)->toDateTimeImmutable() : $carbon->toDateTimeImmutable();
                $end =  $carbon->setDays($accountantDateModel->day)->endOfDay()->toDateTimeImmutable();
                $items[] = [
                    'start_at' => $start,
                    'end_at' => $end,
                    'month' => $carbon->month
                ];
                return $end;
            });
        }
        if ($accountantDateModel->items) {
            $accountantDateModel->items()->delete();
        }
        $accountantDateModel->items()->createMany($items);
    }
}
