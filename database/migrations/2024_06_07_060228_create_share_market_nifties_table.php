<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareMarketNiftiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_market_nifties', function (Blueprint $table) {
            $table->id();
            $table->string('strike_price');
            $table->date('expiry_date');
            $table->enum('type', ['CE', 'PE']); // Call or Put option
            $table->string('identifier')->nullable();
            $table->string('underlying')->nullable();
            $table->integer('open_interest')->nullable();
            $table->integer('change_in_open_interest')->nullable();
            $table->float('pchange_in_open_interest')->nullable();
            $table->integer('total_traded_volume')->nullable();
            $table->float('implied_volatility')->nullable();
            $table->float('last_price')->nullable();
            $table->float('change')->nullable();
            $table->float('pchange')->nullable();
            $table->integer('total_buy_quantity')->nullable();
            $table->integer('total_sell_quantity')->nullable();
            $table->integer('bid_qty')->nullable();
            $table->float('bid_price')->nullable();
            $table->integer('ask_qty')->nullable();
            $table->float('ask_price')->nullable();
            $table->float('underlying_value')->nullable();
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
        Schema::dropIfExists('share_market_nifties');
    }
}
