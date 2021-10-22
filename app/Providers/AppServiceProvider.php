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

namespace App\Providers;

use App\Models\AccountantDateModel;
use App\Models\ApplyForBatchModel;
use App\Models\ApplyForItemModel;
use App\Models\ApplyForOrderModel;
use App\Models\CheckProductModel;
use App\Models\CostItemModel;
use App\Models\CostOrderModel;
use App\Models\InitStockOrderModel;
use App\Models\InventoryItemModel;
use App\Models\InventoryModel;
use App\Models\InventoryOrderModel;
use App\Models\MakeProductItemModel;
use App\Models\MakeProductOrderModel;
use App\Models\ProductModel;
use App\Models\PurchaseInOrderModel;
use App\Models\PurchaseItemModel;
use App\Models\PurchaseOrderModel;
use App\Models\SaleOrderModel;
use App\Models\SaleOutBatchModel;
use App\Models\SaleOutItemModel;
use App\Models\SaleOutOrderModel;
use App\Models\SkuStockBatchModel;
use App\Models\SkuStockModel;
use App\Models\StatementItemModel;
use App\Models\StatementOrderModel;
use App\Models\StockHistoryModel;
use App\Models\TaskModel;
use App\Observers\AccountantDateObserver;
use App\Observers\ApplyForBatchObserver;
use App\Observers\ApplyForItemObserver;
use App\Observers\ApplyForOrderObserver;
use App\Observers\CheckProductObserver;
use App\Observers\CostItemObserver;
use App\Observers\CostOrderObserver;
use App\Observers\InitStockOrderObserver;
use App\Observers\InventoryItemObserver;
use App\Observers\InventoryObserver;
use App\Observers\InventoryOrderObserver;
use App\Observers\MakeProductItemObserver;
use App\Observers\MakeProductOrderObserver;
use App\Observers\OrderNoCreatedObserver;
use App\Observers\ProductObserver;
use App\Observers\PurchaseInOrderObserver;
use App\Observers\PurchaseItemObserver;
use App\Observers\PurchaseOrderObserver;
use App\Observers\SaleOrderObserver;
use App\Observers\SaleOutBatchObserver;
use App\Observers\SaleOutItemObserver;
use App\Observers\SaleOutOrderObserver;
use App\Observers\SkuStockBatchObserver;
use App\Observers\SkuStockObserver;
use App\Observers\StatementItemObserver;
use App\Observers\StatementOrderObserver;
use App\Observers\StockHistoryObserver;
use App\Observers\TaskObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal() && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        }
        if ($this->app->isLocal() && class_exists(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class)) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ProductModel::observe(ProductObserver::class);
        PurchaseOrderModel::observe([PurchaseOrderObserver::class, OrderNoCreatedObserver::class]);
        PurchaseItemModel::observe(PurchaseItemObserver::class);
        PurchaseInOrderModel::observe([PurchaseInOrderObserver::class, OrderNoCreatedObserver::class]);
        SkuStockModel::observe(SkuStockObserver::class);
        SkuStockBatchModel::observe(SkuStockBatchObserver::class);
        StockHistoryModel::observe(StockHistoryObserver::class);
        SaleOrderModel::observe([SaleOrderObserver::class, OrderNoCreatedObserver::class]);
        SaleOutBatchModel::observe(SaleOutBatchObserver::class);
        SaleOutItemModel::observe(SaleOutItemObserver::class);
        SaleOutOrderModel::observe([SaleOutOrderObserver::class, OrderNoCreatedObserver::class]);
        CheckProductModel::observe(CheckProductObserver::class);
        TaskModel::observe([TaskObserver::class, OrderNoCreatedObserver::class]);
        ApplyForOrderModel::observe([ApplyForOrderObserver::class, OrderNoCreatedObserver::class]);
        ApplyForItemModel::observe(ApplyForItemObserver::class);
        ApplyForBatchModel::observe(ApplyForBatchObserver::class);
        MakeProductOrderModel::observe([MakeProductOrderObserver::class, OrderNoCreatedObserver::class]);
        MakeProductItemModel::observe(MakeProductItemObserver::class);
        InventoryModel::observe([InventoryObserver::class, OrderNoCreatedObserver::class]);
        InventoryItemModel::observe(InventoryItemObserver::class);
        InventoryOrderModel::observe([InventoryOrderObserver::class, OrderNoCreatedObserver::class]);
        InitStockOrderModel::observe([InitStockOrderObserver::class, OrderNoCreatedObserver::class]);
        CostOrderModel::observe([CostOrderObserver::class, OrderNoCreatedObserver::class]);
        CostItemModel::observe(CostItemObserver::class);
        AccountantDateModel::observe(AccountantDateObserver::class);
        StatementItemModel::observe(StatementItemObserver::class);
        StatementOrderModel::observe([StatementOrderObserver::class, OrderNoCreatedObserver::class]);
    }
}
