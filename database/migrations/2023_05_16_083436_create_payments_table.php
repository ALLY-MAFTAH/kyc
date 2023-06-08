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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->double('amount');
            $table->bigInteger('stall_id')->nullable();
            $table->bigInteger('frame_id')->nullable();
            $table->bigInteger('market_id');
            $table->bigInteger('customer_id');
            $table->string('receipt_number');
            $table->integer('year');
            $table->string('month');
            $table->unique(['stall_id', 'customer_id', 'year', 'month']);
            $table->unique(['frame_id', 'customer_id', 'year', 'month']);
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
        Schema::dropIfExists('payments');
    }
};
