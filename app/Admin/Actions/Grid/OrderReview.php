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

namespace App\Admin\Actions\Grid;

use App\Models\BaseModel;
use App\Models\InventoryModel;
use App\Models\TaskModel;
use Dcat\Admin\Grid\Tools\AbstractTool;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yxx\LaravelQuick\Exceptions\Api\ApiRequestException;
use Yxx\LaravelQuick\Exceptions\Api\ApiSystemException;

class OrderReview extends AbstractTool
{
    /**
     * @var int
     */
    protected $review_status;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    const REVIEW_STATUS = [
        BaseModel::REVIEW_STATUS_OK       => '审核',
        BaseModel::REVIEW_STATUS_REREVIEW => '反审核',
    ];

    public function __construct($review_status = null)
    {
        $title = Arr::get(self::REVIEW_STATUS, $review_status);
        if (isset($review_status) && $title) {
            $this->title         = $title;
            $this->review_status = $review_status;
        }
    }

    public function handle(Request $request)
    {
        $title = Arr::get(self::REVIEW_STATUS, $request->input("review_status"));
        try {
            $this->check($request);
            DB::transaction(function () use ($request) {
                $this->model->review_status = $request->input("review_status");
                return $this->model->save();
            });
            return $this->response()->success("单据{$title}成功！")->refresh();
        } catch (\Exception $exception) {
            return $this->response()->error("单据{$title}失败！". $exception->getMessage());
        }
    }

    protected function check(Request $request): void
    {
        $id         = $request->input('id');
        $model      = $request->input('model');
        $modelClass = "\\App\Models\\" . $model;
        $table = $request->input('table');

        if (! class_exists($modelClass)) {
            throw new ApiRequestException("参数错误！");
        }

        $this->model = $modelClass::find($id);

        $check_func = Str::camel($table . "_check");

        if ($table !== "inventory_order") {
            $orderNos = InventoryModel::query()
                ->where('status', InventoryModel::STATUS_WAIT)
                ->pluck('order_no');
            if ($orderNos->count()) {
                throw new ApiSystemException("单据审核失败！盘点任务{$orderNos->implode("order_no", ",")}正在进行中！");
            }
        }

        if (method_exists($this, $check_func)) {
            \call_user_func([$this, $check_func]);
        } else {
            if ($this->model->items->count() === 0) {
                throw new \Exception('订单明细不能为空！');
            }
            if ($this->model->items()->where('actual_num', 0)->count()) {
                throw new \Exception('明细数量不能为0！');
            }
        }
    }

    public function saleOrderCheck():void
    {
        if ($this->model->items->count() === 0) {
            throw new \Exception('订单明细不能为空！');
        }
        if ($this->model->items()->where('should_num', 0)->count()) {
            throw new \Exception('明细数量不能为0！');
        }
    }

    public function purchaseOrderCheck():void
    {
        if ($this->model->items->count() === 0) {
            throw new \Exception('订单明细不能为空！');
        }
        if ($this->model->items()->where('should_num', 0)->count()) {
            throw new \Exception('明细数量不能为0！');
        }
    }

    public function statementOrderCheck():void
    {
        if ($this->model->items->count() === 0) {
            throw new \Exception('订单明细不能为空！');
        }
    }

    public function applyForOrderCheck():void
    {
        $taskStatus = $this->model->with_order->status;
        if ($taskStatus > TaskModel::STATUS_DRAW) {
            throw new \Exception("任务状态为". TaskModel::STATUS[$taskStatus] .",无法完成审核");
        }
        if ($this->model->items->count() === 0) {
            throw new \Exception('订单明细不能为空！');
        }
        if ($this->model->items()->where('actual_num', 0)->count()) {
            throw new \Exception('明细数量不能为0！');
        }
    }

    public function makeProductOrderCheck():void
    {
        $taskStatus = $this->model->with_order->status;
        if ($taskStatus !== TaskModel::STATUS_DRAW) {
            throw new \Exception("任务状态为". TaskModel::STATUS[$taskStatus] .",无法完成审核");
        }

        if ($this->model->items->count() === 0) {
            throw new \Exception('订单明细不能为空！');
        }
        if ($this->model->items()->where('actual_num', 0)->count()) {
            throw new \Exception('明细数量不能为0！');
        }
    }

    public function CostOrderCheck():void
    {
        if ($this->model->items->count() === 0) {
            throw new \Exception('订单明细不能为空！');
        }
    }

    public function InventoryOrderCheck():void
    {
        $with_order = $this->model->with_order;
        if ($with_order->status !== InventoryModel::STATUS_WAIT) {
            throw new \Exception("盘点任务{$with_order->order_no}的时间段是{$with_order->start_at}至{$with_order->end_at}，当前时间无法审核！");
        }
        if ($this->model->items->count() === 0) {
            throw new \Exception('订单明细不能为空！');
        }
//        if ($this->model->items()->where('actual_num', 0)->count()) {
//            throw new \Exception('明细数量不能为0！');
//        }
    }

    /**
     * @return string
     */
    public function html(): string
    {
        return <<<HTML
<a {$this->formatHtmlAttributes()}><button class="btn btn-primary btn-mini"><i class="feather icon-user-check"></i> {$this->title()}</button></a>
HTML;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return admin_controller_name() . 'Model';
    }

    /**
     * @return array
     */
    protected function parameters(): array
    {
        return [
            'table'         => $this->getTable(),
            'model'         => $this->getModel(),
            'review_status' => $this->review_status,
            'id' => request()->route()->parameter($this->getTable()),
        ];
    }

    public function getTable():string
    {
        return Str::snake(admin_controller_name());
    }

    /**
     * @return array
     */
    public function confirm(): array
    {
        return ["你确定要{$this->title}单据?"];
    }
}
