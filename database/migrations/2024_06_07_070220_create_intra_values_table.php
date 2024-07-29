<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntraValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intra_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('intraday_id')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('buy_or_sale')->nullable();
            $table->string('nifty_or_banknifty')->nullable();
            $table->string('featureby_or_optionby')->nullable();
            $table->string('quantity')->nullable();
            $table->foreign('intraday_id')->references('id')->on('intradays')->onDelete('cascade');
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
        Schema::dropIfExists('intra_values');
    }
}
