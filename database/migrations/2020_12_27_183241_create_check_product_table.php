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

class CreateCheckProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_product', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('sku_stock_batch_id')->default(0)->comment('关联批次库存id');
            $table->unsignedTinyInteger('standard')->default(0)->comment('检验标准');
            $table->decimal('carbon_fiber', 10, 2)->default(0.00)->comment('碳纤维');
            $table->decimal('percent', 10, 2)->default(0)->comment('含绒量');
            $table->decimal('raw_footage', 10, 2)->default(0.00)->comment('毛片');
            $table->decimal('velvet', 10, 2)->default(0.00)->comment('朵绒');
            $table->decimal('magazine', 10, 2)->default(0.00)->comment('杂志');
            $table->decimal('fluffy_silk', 10, 2)->default(0.00)->comment('绒丝');
            $table->decimal('terrestrial_feather', 10, 2)->default(0.00)->comment('陆禽毛');
            $table->decimal('feather_silk', 10, 2)->default(0.00)->comment('羽丝');
            $table->decimal('heterochromatic_hair', 10, 2)->default(0.00)->comment('异色毛');
            $table->decimal('flower_number', 10, 2)->default(0.00)->comment('朵数');
            $table->decimal('blackhead', 10, 2)->default(0.00)->comment('黑头');
            $table->decimal('cleanliness', 10, 2)->default(0.00)->comment('清洁度');
            $table->decimal('moisture', 10, 2)->default(0.00)->comment('水份');
            $table->decimal('bulkiness', 10, 2)->default(0.00)->comment('蓬松度');
            $table->decimal('odor', 10, 2)->default(0.00)->comment('气味');
            $table->decimal('duck_ratio', 10, 2)->default(0.00)->comment('鸭比');
            $table->unsignedInteger('user_id')->default(0)->comment('质检员');
            $table->softDeletes();
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
        Schema::dropIfExists('check_product');
    }
}
