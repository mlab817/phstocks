<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->decimal('open', 15, 2)->default(0);
            $table->decimal('high', 15, 2)->default(0);
            $table->decimal('low', 15, 2)->default(0);
            $table->decimal('close', 15, 2)->default(0);
            $table->decimal('average', 15, 2)->default(0);
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
        Schema::dropIfExists('stock_histories');
    }
}
