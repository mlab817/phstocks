<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_stocks', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('stock_id')->constrained()->cascadeOnDelete();
            $table->decimal('last_price', 15, 2)->default(0);
            $table->decimal('pct_change', 15, 2)->default(0);
            $table->unsignedBigInteger('volume')->default(0);
            $table->decimal('value', 15, 2)->default(0);
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
        Schema::dropIfExists('active_stocks');
    }
}
