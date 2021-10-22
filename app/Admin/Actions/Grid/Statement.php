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

use App\Models\CostOrderModel;
use App\Models\CustomerModel;
use App\Models\StatementOrderModel;
use App\Models\SupplierModel;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid\BatchAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Statement extends BatchAction
{
    /**
     * @return string
     */
    protected $title = '结算';

    protected function html(): string
    {
        return <<<HTML
<a {$this->formatHtmlAttributes()}><button class="btn btn-primary btn-mini"><i class="feather icon-user-check"></i> {$this->title()}</button></a>
HTML;
    }

    public function handle(Request $request)
    {
        $index                     = $request->input('_index');
        $func = "statement" .$request->input('_func');
        try {
            if (method_exists($this, $func)) {
                \call_user_func([$this, $func]);
            }
            return $this->response()->script("parent.layer.close({$index})");
        } catch (\Exception $exception) {
            return  $this->response()->error($exception->getMessage())->refresh();
        }
    }

    /**
     * @param  int  $category
     * @return Collection
     */
    public function getCostOrders(int $category): Collection
    {
        return CostOrderModel::query()->where(function (Builder $builder) use ($category) {
            $builder->where('category', $category);
            $builder->whereIn('company_id', $this->getKey());
            $builder->where('review_status', CostOrderModel::REVIEW_STATUS_OK);
            $builder->where('settlement_completed', CostOrderModel::SETTLEMENT_UNDONE);
        })->get()->groupBy('company_id');
    }

    public function createStatementOrder(Collection $costOrders, int $category)
    {
        $costOrders->each(function (Collection $collection, int $companyId) use ($category) {
            $statementOrderExists = $this->statementOrderExists($category, $companyId);

            if ($statementOrderExists) {
                $model = ($category === StatementOrderModel::CATEGORY_SUPPLIER)
                    ? SupplierModel::query() : CustomerModel::query();
                $company = $model->findOrFail($companyId);
                throw new \Exception(StatementOrderModel::CATEGORY[$category] . $company->name ."有一笔待审核的结算单！");
            }

            $collection->transform(function (CostOrderModel $costOrderModel) {
                $should_amount = bcsub($costOrderModel->total_amount, bcadd($costOrderModel->settlement_amount, $costOrderModel->discount_amount, 5), 5);
                return [
                    'statement_order_id' => $costOrderModel->id,
                    'order_amount' => $costOrderModel->total_amount,
                    'should_amount' => $should_amount,
                    'already_actual_amount' => $costOrderModel->settlement_amount,
                    'already_discount_amount' => $costOrderModel->discount_amount
                ];
            });
            DB::transaction(function () use ($companyId, $category, $collection) {
                $statementOrder = StatementOrderModel::query()->create([
                    'order_no' => build_order_no('JS'),
                    'category' => $category,
                    'company_id' => $companyId,
                    'apply_id' => Admin::user()->id,
                    'user_id' => Admin::user()->id,
                    'should_amount' => $collection->sum('should_amount'),
                ]);
                $statementOrder->items()->createMany($collection);
            });
        });
    }

    public function statementOrderExists(int $category, $companyId):bool
    {
        return StatementOrderModel::query()->where([
            'category' => $category,
            'company_id' => $companyId,
            'review_status' => StatementOrderModel::REVIEW_STATUS_WAIT
        ])->exists();
    }

    /**
     * @throws \Exception
     */
    public function statementSupplier():void
    {
        $costOrders = $this->getCostOrders(CostOrderModel::CATEGORY_SUPPLIER);

        $this->createStatementOrder($costOrders, CostOrderModel::CATEGORY_SUPPLIER);
    }

    /**
     * @throws \Exception
     */
    public function statementCustomer():void
    {
        $costOrders = $this->getCostOrders(CostOrderModel::CATEGORY_CUSTOMER);

        $this->createStatementOrder($costOrders, CostOrderModel::CATEGORY_CUSTOMER);
    }

    public function actionScript(): string
    {
        $func = admin_controller_name();
        $warning = "请选择结算的数据！";

        return <<<JS
function (data, target, action) {
    var key = {$this->getSelectedKeysScript()}

    if (key.length === 0) {
        Dcat.warning('{$warning}');
        return false;
    }
    data["_index"] = parent.layer.getFrameIndex(window.name);
    data["_func"] = "{$func}";
    // 设置主键为复选框选中的行ID数组
    action.options.key = key;
}
JS;
    }
}
