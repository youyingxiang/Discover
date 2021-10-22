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

class AddPercentIntoSaleOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_in_item', function (Blueprint $table) {
            $table->decimal('percent', 10, 2)->default(0)->comment('含绒量');
            $table->unsignedTinyInteger('standard')->default(0)->comment('检验标准');
        });

        Schema::table('sale_out_item', function (Blueprint $table) {
            $table->decimal('percent', 10, 2)->default(0)->comment('含绒量');
            $table->unsignedTinyInteger('standard')->default(0)->comment('检验标准');
        });

        Schema::table('sale_item', function (Blueprint $table) {
            $table->decimal('percent', 10, 2)->default(0)->comment('含绒量');
            $table->unsignedTinyInteger('standard')->default(0)->comment('检验标准');
        });

        Schema::table('sale_out_batch', function (Blueprint $table) {
            $table->decimal('percent', 10, 2)->default(0)->comment('含绒量');
            $table->unsignedTinyInteger('standard')->default(0)->comment('检验标准');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_in_item', function (Blueprint $table) {
            $table->dropColumn('percent');
            $table->dropColumn('standard');
        });

        Schema::table('sale_out_item', function (Blueprint $table) {
            $table->dropColumn('percent');
            $table->dropColumn('standard');
        });

        Schema::table('sale_item', function (Blueprint $table) {
            $table->dropColumn('percent');
            $table->dropColumn('standard');
        });

        Schema::table('sale_out_batch', function (Blueprint $table) {
            $table->dropColumn('percent');
            $table->dropColumn('standard');
        });
    }
}
