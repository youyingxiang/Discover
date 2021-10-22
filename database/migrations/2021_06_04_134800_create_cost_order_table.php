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

class CreateCostOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_no')->unique()->default('');
            $table->unsignedTinyInteger('category')->default(0);
            $table->unsignedInteger('category_user')->default(0);
            $table->string('other')->default('');
            $table->unsignedInteger('user_id')->default(0);
            $table->unsignedInteger('apply_id')->default(0);
            $table->unsignedTinyInteger('review_status')->default(0);
            $table->unsignedInteger('accountant_item_id')->default(0);
            $table->unsignedDecimal('total_amount')->default(0.00);
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
        Schema::dropIfExists('cost_order');
    }
}
