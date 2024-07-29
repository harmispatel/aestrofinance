<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGannStokesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gann_stokes', function (Blueprint $table) {
            $table->id();
            $table->string('stokes')->nullable();
            $table->tinyInteger('stoke_category')->default(1);
            $table->string('d_0')->nullable();
            $table->string('price_low_0')->nullable();
            $table->string('price_high_0')->nullable();
            $table->string('close_0')->nullable();
            $table->string('d_30')->nullable();
            $table->string('price_low_30')->nullable();
            $table->string('price_high_30')->nullable();
            $table->string('close_30')->nullable();
            $table->string('d_45')->nullable();
            $table->string('price_low_45')->nullable();
            $table->string('price_high_45')->nullable();
            $table->string('close_45')->nullable();
            $table->string('d_60')->nullable();
            $table->string('price_low_60')->nullable();
            $table->string('price_high_60')->nullable();
            $table->string('close_60')->nullable();
            $table->string('d_72')->nullable();
            $table->string('price_low_72')->nullable();
            $table->string('price_high_72')->nullable();
            $table->string('close_72')->nullable();
            $table->string('d_90')->nullable();
            $table->string('price_low_90')->nullable();
            $table->string('price_high_90')->nullable();
            $table->string('close_90')->nullable();
            $table->string('d_120')->nullable();
            $table->string('price_low_120')->nullable();
            $table->string('price_high_120')->nullable();
            $table->string('close_120')->nullable();
            $table->string('d_135')->nullable();
            $table->string('price_low_135')->nullable();
            $table->string('price_high_135')->nullable();
            $table->string('close_135')->nullable();
            $table->string('d_150')->nullable();
            $table->string('price_low_150')->nullable();
            $table->string('price_high_150')->nullable();
            $table->string('close_150')->nullable();
            $table->string('d_180')->nullable();
            $table->string('price_low_180')->nullable();
            $table->string('price_high_180')->nullable();
            $table->string('close_180')->nullable();
            $table->string('d_210')->nullable();
            $table->string('price_low_210')->nullable();
            $table->string('price_high_210')->nullable();
            $table->string('close_210')->nullable();
            $table->string('d_225')->nullable();
            $table->string('price_low_225')->nullable();
            $table->string('price_high_225')->nullable();
            $table->string('close_225')->nullable();
            $table->string('d_240')->nullable();
            $table->string('price_low_240')->nullable();
            $table->string('price_high_240')->nullable();
            $table->string('close_240')->nullable();
            $table->string('d_252')->nullable();
            $table->string('price_low_252')->nullable();
            $table->string('price_high_252')->nullable();
            $table->string('close_252')->nullable();
            $table->string('d_270')->nullable();
            $table->string('price_low_270')->nullable();
            $table->string('price_high_270')->nullable();
            $table->string('close_270')->nullable();
            $table->string('d_288')->nullable();
            $table->string('price_low_288')->nullable();
            $table->string('price_high_288')->nullable();
            $table->string('close_288')->nullable();
            $table->string('d_300')->nullable();
            $table->string('price_low_300')->nullable();
            $table->string('price_high_300')->nullable();
            $table->string('close_300')->nullable();
            $table->string('d_315')->nullable();
            $table->string('price_low_315')->nullable();
            $table->string('price_high_315')->nullable();
            $table->string('close_315')->nullable();
            $table->string('d_330')->nullable();
            $table->string('price_low_330')->nullable();
            $table->string('price_high_330')->nullable();
            $table->string('close_330')->nullable();
            $table->string('d_360')->nullable();
            $table->string('price_low_360')->nullable();
            $table->string('price_high_360')->nullable();
            $table->string('close_360')->nullable();
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
        Schema::dropIfExists('gann_stokes');
    }
}
