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
        Schema::create('stalls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->unique(['code', 'market_id']);
            $table->double('price');
            $table->string('type');
            $table->bigInteger('market_id');
            $table->bigInteger('customer_id')->nullable();
            $table->string('location');
            $table->string('size')->nullable();
            $table->string('business')->nullable();
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
        Schema::dropIfExists('stalls');
    }
};
