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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name', 64)->default('')->comment('产品名称');
            $table->string('py_code', 32)->default('')->comment('拼音码');
            $table->string('item_no', 32)->default('')->comment('产品编号');
            $table->unsignedSmallInteger('unit_id')->default(0)->comment('单位');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_attr', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('product_id')->default(0)->comment('产品id');
            $table->unsignedInteger('attr_id')->default(0)->comment('属性id');
            $table->json('attr_value_ids')->comment('产品可选值');
        });

        Schema::create('attr', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name', 64)->default('')->comment('属性名称');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('attr_value', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('attr_id')->default(0)->comment('属性id');
            $table->string('name', 64)->default('')->comment('属性值名称');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_sku', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('product_id')->default(0)->comment('产品id');
            $table->string('attr_value_ids', 500)->comment('选项值ids');
        });
        Schema::create('unit', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name', 64)->default('')->comment('单位名称');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('purchase_check', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('check_order_id')->default(0)->comment('检验单id');
            $table->unsignedInteger('purchase_order_id')->default(0)->comment('采购单id');
        });
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('order_no')->default('')->unique()->comment('订单单号');
            $table->unsignedInteger('supplier_id')->default(0)->comment('供应商id');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态');
            $table->string('other')->default('')->comment('备注');
            $table->unsignedTinyInteger('check_status')->default(0)->comment('检测状态');
            $table->unsignedInteger('user_id')->default(0)->comment('创建订单用户');
            $table->timestamp('finished_at')->nullable()->comment('订单完成时间');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('purchase_item', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('order_id')->default(0)->comment('订单id');
            $table->unsignedInteger('sku_id')->default(0)->comment('采购商品的skuid');
            $table->unsignedInteger('should_num')->default(0)->comment('采购数量');
            $table->unsignedInteger('actual_num')->default(0)->comment('入库数量');
            $table->decimal('price', 10, 2)->default(0)->comment('价格');
            $table->timestamps();
        });
        Schema::create('supplier', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name', 64)->default('')->comment('供应商名称');
            $table->string('link', 64)->default('')->comment('联系人');
            $table->unsignedTinyInteger('pay_method')->default(0)->comment('结算方式');
            $table->string('phone')->default('')->comment('手机号');
            $table->string('other')->default('')->comment('备注');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('position', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name', 64)->default('')->comment('位置名称');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('purchase_in_order', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('order_no')->default('')->unique()->comment('订单单号');
            $table->unsignedInteger('supplier_id')->default(0)->comment('供应商id');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态');
            $table->string('other')->default('')->comment('备注');
            $table->unsignedInteger('user_id')->default(0)->comment('创建订单用户');
            $table->timestamp('finished_at')->nullable()->comment('订单完成时间');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('purchase_in_item', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('order_id')->default(0)->comment('订单id');
            $table->unsignedInteger('sku_id')->default(0)->comment('采购商品的skuid');
            $table->unsignedInteger('should_num')->default(0)->comment('采购数量');
            $table->unsignedInteger('actual_num')->default(0)->comment('入库数量');
            $table->decimal('price', 10, 2)->default(0)->comment('价格');
            $table->unsignedInteger('position_id')->default(0)->comment('位置id');
            $table->string('batch_no', 32)->default('')->comment('批次号');
            $table->timestamps();
        });

        Schema::create('sku_stock', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('sku_id')->default(0)->comment('产品sku_id');
            $table->integer('num')->default(0)->comment('产品库存');
            $table->timestamps();
        });

        Schema::create('sku_stock_batch', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('sku_id')->default(0)->comment('产品sku_id');
            $table->integer('num')->default(0)->comment('产品库存');
            $table->unsignedInteger('position_id')->default(0)->comment('仓库位置');
            $table->string('batch_no', 32)->default('')->comment('批次号');
            $table->timestamps();
        });
        Schema::create('customer', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name', 128)->default('')->comment('属性名称');
            $table->string('link', 64)->default('')->comment('联系人');
            $table->unsignedTinyInteger('pay_method')->default(0)->comment('支付方式');
            $table->string('phone', 11)->default('')->comment('手机号码');
            $table->string('other', 500)->default('')->comment('备注');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('customer_address', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('customer_id')->default(0)->comment('客户档案id');
            $table->string('address')->default('')->comment('地址');
            $table->string('other')->default('')->comment('备注');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('drawee', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name', 128)->default('')->comment('付款人名称');
            $table->timestamps();
        });

        Schema::create('customer_drawee', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('customer_id')->default(0)->comment('客户档案id');
            $table->unsignedInteger('drawee_id')->default(0)->comment('付款人id');
        });

        Schema::create('sale_order', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('order_no')->default('')->unique()->comment('订单单号');
            $table->unsignedInteger('customer_id')->default(0)->comment('客户档案');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态');
            $table->string('other')->default('')->comment('备注');
            $table->unsignedInteger('user_id')->default(0)->comment('创建订单用户');
            $table->timestamp('finished_at')->nullable()->comment('订单完成时间');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('sale_item', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('order_id')->default(0)->comment('订单id');
            $table->unsignedInteger('sku_id')->default(0)->comment('商品的skuid');
            $table->unsignedInteger('should_num')->default(0)->comment('销售数量');
            $table->unsignedInteger('actual_num')->default(0)->comment('出库数量');
            $table->decimal('price', 10, 2)->default(0)->comment('价格');
            $table->unsignedInteger('position_id')->default(0)->comment('位置id');
            $table->string('batch_no', 32)->default('')->comment('批次号');
            $table->timestamps();
        });

        Schema::create('sale_out_order', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('order_no')->default('')->unique()->comment('订单单号');
            $table->unsignedInteger('customer_id')->default(0)->comment('客户档案');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态');
            $table->string('other')->default('')->comment('备注');
            $table->unsignedInteger('user_id')->default(0)->comment('创建订单用户');
            $table->timestamp('finished_at')->nullable()->comment('订单完成时间');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('sale_out_item', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('order_id')->default(0)->comment('订单id');
            $table->unsignedInteger('sku_id')->default(0)->comment('商品的skuid');
            $table->unsignedInteger('should_num')->default(0)->comment('销售数量');
            $table->unsignedInteger('actual_num')->default(0)->comment('出库数量');
            $table->decimal('price', 10, 2)->default(0)->comment('价格');
            $table->unsignedInteger('position_id')->default(0)->comment('位置id');
            $table->string('batch_no', 32)->default('')->comment('批次号');
            $table->timestamps();
        });

        Schema::create('sale_in_order', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('order_no')->default('')->unique()->comment('订单单号');
            $table->unsignedInteger('customer_id')->default(0)->comment('客户档案');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态');
            $table->string('other')->default('')->comment('备注');
            $table->unsignedInteger('user_id')->default(0)->comment('创建订单用户');
            $table->timestamp('finished_at')->nullable()->comment('订单完成时间');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('sale_in_item', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('order_id')->default(0)->comment('订单id');
            $table->unsignedInteger('sku_id')->default(0)->comment('商品的skuid');
            $table->unsignedInteger('should_num')->default(0)->comment('销售数量');
            $table->unsignedInteger('actual_num')->default(0)->comment('出库数量');
            $table->unsignedInteger('return_num')->default(0)->comment('退回数量');
            $table->decimal('price', 10, 2)->default(0)->comment('价格');
            $table->unsignedInteger('position_id')->default(0)->comment('位置id');
            $table->string('batch_no', 32)->default('')->comment('批次号');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
        Schema::dropIfExists('product_attr');
        Schema::dropIfExists('attr');
        Schema::dropIfExists('attr_value');
        Schema::dropIfExists('product_sku');
        Schema::dropIfExists('unit');
        Schema::dropIfExists('check_order');
        Schema::dropIfExists('purchase_check');
        Schema::dropIfExists('purchase_order');
        Schema::dropIfExists('purchase_item');
        Schema::dropIfExists('supplier');
        Schema::dropIfExists('position');
        Schema::dropIfExists('purchase_in_order');
        Schema::dropIfExists('purchase_in_item');
        Schema::dropIfExists('sku_stock');
        Schema::dropIfExists('sku_stock_batch');
        Schema::dropIfExists('customer');
        Schema::dropIfExists('customer_address');
        Schema::dropIfExists('drawee');
        Schema::dropIfExists('customer_drawee');
        Schema::dropIfExists('sale_order');
        Schema::dropIfExists('sale_item');
        Schema::dropIfExists('sale_out_order');
        Schema::dropIfExists('sale_out_item');
        Schema::dropIfExists('sale_in_order');
        Schema::dropIfExists('sale_in_item');
    }
}
