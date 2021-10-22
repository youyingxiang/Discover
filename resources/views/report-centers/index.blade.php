<style>
    .fonticon-container>.fonticon-wrap {
        float: left;
        width: 60px;
        height: 60px;
        line-height: 4.8rem;
        text-align: center;
        border-radius: .1875rem;
        margin-right: 1rem;
        margin-bottom: 1.5rem;
    }
    .fonticon-container>.fonticon-wrap>i {
        font-size: 2.28rem;
        transition: all .2s ease-in-out;
    }
    .fonticon-container>.fonticon-classname, .fonticon-container>.fonticon-unit {
        display: block;
        font-size: 1.5rem;
        line-height: 1.2;
    }
</style>

    <div class="card" style="padding-top: 20px">
        <div class="card-header text-85">财务相关</div>
        <div class="card-body">
            <div class="feather-icons overflow-hidden row">
                <a class="col-md-4 col-sm-6 col-12 fonticon-container" target="_blank" href="{{route('financial.settlement-history')}}">
                    <div class="fonticon-wrap">
                        <i class="feather icon-activity"></i>
                    </div>
                    <span class="fonticon-classname mt-1">结算往来帐</span>
                </a>
                <a class="col-md-4 col-sm-6 col-12 fonticon-container" target="_blank" href="{{route('financial.cost-order-statistical')}}">
                    <div class="fonticon-wrap">
                        <i class="feather icon-activity"></i>
                    </div>
                    <span class="fonticon-classname mt-1">费用汇总</span>
                </a>

                <a class="col-md-4 col-sm-6 col-12 fonticon-container" target="_blank" href="{{route('financial.unsettled-cost')}}">
                    <div class="fonticon-wrap">
                        <i class="feather icon-activity"></i>
                    </div>
                    <span class="fonticon-classname mt-1">未结算费用报表</span>
                </a>

            </div>
        </div>
        <div class="card-header text-85">采购相关</div>
        <div class="card-body">
            <div class="feather-icons overflow-hidden row">
                <a class="col-md-4 col-sm-6 col-12 fonticon-container" target="_blank" href="{{route('purchase-report.items')}}">
                    <div class="fonticon-wrap">
                        <i class="feather icon-activity"></i>
                    </div>
                    <span class="fonticon-classname mt-1">采购入库明细</span>
                </a>
                <a class="col-md-4 col-sm-6 col-12 fonticon-container" target="_blank" href="{{route('purchase-report.summary-by-supplier')}}">
                    <div class="fonticon-wrap">
                        <i class="feather icon-activity"></i>
                    </div>
                    <span class="fonticon-classname mt-1">采购入库汇总(供应商)</span>
                </a>

                <a class="col-md-4 col-sm-6 col-12 fonticon-container" target="_blank" href="{{ route('purchase-report.summary-by-sku') }}">
                    <div class="fonticon-wrap">
                        <i class="feather icon-activity"></i>
                    </div>
                    <span class="fonticon-classname mt-1">采购入库汇总(产品)</span>
                </a>

                <a class="col-md-4 col-sm-6 col-12 fonticon-container" target="_blank" href="{{route('purchase-report.order-amount')}}">
                    <div class="fonticon-wrap">
                        <i class="feather icon-activity"></i>
                    </div>
                    <span class="fonticon-classname mt-1">采购订单金额</span>
                </a>
            </div>
        </div>
        <div class="card-header text-85">销售相关</div>
        <div class="card-body">
            <div class="feather-icons overflow-hidden row">
                <a class="col-md-4 col-sm-6 col-12 fonticon-container" target="_blank" href="{{route('sale-report.items')}}">
                    <div class="fonticon-wrap">
                        <i class="feather icon-activity"></i>
                    </div>
                    <span class="fonticon-classname mt-1">销售成本毛利明细</span>
                </a>
                <a class="col-md-4 col-sm-6 col-12 fonticon-container" target="_blank" href="{{route('sale-report.summary-by-customer')}}">
                    <div class="fonticon-wrap">
                        <i class="feather icon-activity"></i>
                    </div>
                    <span class="fonticon-classname mt-1">销售出库汇总(客户)</span>
                </a>

                <a class="col-md-4 col-sm-6 col-12 fonticon-container" target="_blank" href="{{route('sale-report.summary-by-sku')}}">
                    <div class="fonticon-wrap">
                        <i class="feather icon-activity"></i>
                    </div>
                    <span class="fonticon-classname mt-1">销售出库汇总(产品)</span>
                </a>

                <a class="col-md-4 col-sm-6 col-12 fonticon-container" target="_blank" href="{{route('sale-report.order-amount')}}">
                    <div class="fonticon-wrap">
                        <i class="feather icon-activity"></i>
                    </div>
                    <span class="fonticon-classname mt-1">销售订单金额</span>
                </a>
            </div>
        </div>

        <div class="card-header text-85">生产相关</div>
        <div class="card-body">
            <div class="feather-icons overflow-hidden row">
                <a class="col-md-4 col-sm-6 col-12 fonticon-container" target="_blank" href="{{route('make-product-report.apply-for-items')}}">
                    <div class="fonticon-wrap">
                        <i class="feather icon-activity"></i>
                    </div>
                    <span class="fonticon-classname mt-1">领料出库明细</span>
                </a>
                <a class="col-md-4 col-sm-6 col-12 fonticon-container" target="_blank" href="{{route('make-product-report.apply-for-summary')}}">
                    <div class="fonticon-wrap">
                        <i class="feather icon-activity"></i>
                    </div>
                    <span class="fonticon-classname mt-1">领料出库汇总</span>
                </a>

                <a class="col-md-4 col-sm-6 col-12 fonticon-container" target="_blank" href="{{route('make-product-report.items')}}">
                    <div class="fonticon-wrap">
                        <i class="feather icon-activity"></i>
                    </div>
                    <span class="fonticon-classname mt-1">生产入库明细</span>
                </a>

                <a class="col-md-4 col-sm-6 col-12 fonticon-container" target="_blank" href="{{route('make-product-report.summary')}}">
                    <div class="fonticon-wrap">
                        <i class="feather icon-activity"></i>
                    </div>
                    <span class="fonticon-classname mt-1">生产入库汇总</span>
                </a>
            </div>
        </div>
    </div>


