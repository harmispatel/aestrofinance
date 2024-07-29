<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrentNiftiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_nifties', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('stock')->nullable();
            $table->string('grah_name')->nullable();
            $table->string('deg_absolute')->nullable();
            $table->string('nifty_price')->nullable();
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
        Schema::dropIfExists('current_nifties');
    }
}
