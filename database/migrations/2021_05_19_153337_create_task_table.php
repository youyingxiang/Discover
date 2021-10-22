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

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_no')->default("")->unique()->comment('任务单号');
            $table->unsignedInteger('sku_id')->default(0)->comment('商品');
            $table->unsignedDecimal('percent')->default(0)->comment('含绒量');
            $table->unsignedTinyInteger('standard')->default(0)->comment('检验标准');
            $table->unsignedDecimal('plan_num')->default(0)->comment('计划数量');
            $table->unsignedDecimal('finish_num')->default(0)->comment('完成数量');
            $table->unsignedInteger('craft_id')->default(0)->comment('生产工艺');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态');
            $table->text('other')->nullable()->comment('备注');
            $table->unsignedInteger('user_id')->default(0)->comment('任务创建人');
            $table->unsignedInteger('operator')->default(0)->comment('操作人员');
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
        Schema::dropIfExists('task');
    }
}
