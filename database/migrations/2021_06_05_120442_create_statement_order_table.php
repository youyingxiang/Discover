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

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatementOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statement_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_no')->unique()->default('')->comment('订单号');
            $table->unsignedTinyInteger('category')->default(0)->comment('费用分类');
            $table->unsignedInteger('company_id')->default(0)->comment('公司id');
            $table->string('other')->default('')->comment('备注');
            $table->unsignedInteger('apply_id')->default(0)->comment('审核人');
            $table->unsignedInteger('user_id')->default(0)->comment('创建人');
            $table->unsignedTinyInteger('review_status')->default(0)->comment('审核状态');
            $table->decimal('should_amount')->default(0)->comment('应付金额');
            $table->decimal('actual_amount')->default(0)->comment('实付金额');
            $table->decimal('discount_amount')->default(0)->comment('优惠金额');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statement_order');
    }
}
