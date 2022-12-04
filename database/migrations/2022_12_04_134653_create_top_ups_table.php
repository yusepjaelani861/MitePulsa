<?php

use App\Models\User;
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
        Schema::create('top_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('ref_id')->unique();
            $table->string('customer_no')->nullable();
            $table->string('buyer_sku_code')->nullable();
            $table->string('message')->nullable();
            $table->string('status')->nullable();
            $table->string('rc')->nullable();
            $table->bigInteger('buyer_last_saldo')->nullable();
            $table->string('sn')->nullable();
            $table->bigInteger('price')->nullable();
            $table->string('tele')->nullable();
            $table->string('wa')->nullable();
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
        Schema::dropIfExists('top_ups');
    }
};
