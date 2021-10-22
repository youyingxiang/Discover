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

class ChangeSaleOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_in_order', function (Blueprint $table) {
            $table->unsignedInteger('with_id')->default(0)->comment('相关单据id');
            $table->unsignedTinyInteger('review_status')->default(0)->comment('审核状态');
        });

        Schema::table('sale_out_order', function (Blueprint $table) {
            $table->unsignedInteger('with_id')->default(0)->comment('相关单据id');
            $table->unsignedTinyInteger('review_status')->default(0)->comment('审核状态');
        });

        Schema::table('sale_order', function (Blueprint $table) {
            $table->unsignedTinyInteger('review_status')->default(0)->comment('审核状态');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
