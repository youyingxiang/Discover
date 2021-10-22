<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSumCostPriceIntoMakeProductItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('make_product_item', function (Blueprint $table) {
            $table->unsignedDecimal("sum_cost_price")->default(0.00)->comment('成本总价格');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('make_product_item', function (Blueprint $table) {
            $table->dropColumn('sum_cost_price');
        });
    }
}
