<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('category')->nullable();
            $table->string('brand')->nullable();
            $table->string('type')->nullable();
            $table->string('seller_name')->nullable();
            $table->bigInteger('price')->nullable();
            $table->string('buyer_sku_code')->nullable();
            $table->boolean('buyer_product_status')->default(false);
            $table->boolean('seller_product_status')->default(false);
            $table->boolean('unlimited_stock')->default(false);
            $table->bigInteger('stock')->nullable();
            $table->boolean('multi')->default(false);
            $table->string('start_cut_off')->nullable();
            $table->string('end_cut_off')->nullable();
            $table->string('desc')->nullable();
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
        Schema::dropIfExists('products');
    }
};
