<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cmpy_id');
            $table->unsignedBigInteger('security_id');
            $table->string('name');
            $table->string('symbol');
            $table->string('sector');
            $table->string('subsector');
            $table->string('url');
            $table->date('listing_date')->nullable();
            $table->unsignedBigInteger('outstanding_shares')->default(0);
            $table->text('logo')->nullable();
            $table->bigInteger('pe_ratio')->nullable()->default(0);
            $table->unsignedBigInteger('issued_shares')->default(0);
            $table->unsignedBigInteger('listed_shares')->default(0);
            $table->decimal('free_float_level', 20, 4)->nullable()->default(0);
            $table->decimal('market_capitalization', 20, 4)->nullable()->default(0);
            $table->string('isin')->nullable();
            $table->string('issue_type')->nullable();
            $table->unsignedBigInteger('board_lot')->nullable();
            $table->unsignedBigInteger('par_value')->nullable();
            $table->unsignedBigInteger('foreign_ownership_limit')->nullable();
            $table->decimal('year_end_eps', 20, 4)->nullable()->default(0);
            $table->date('year_end_eps_period')->nullable();
            $table->decimal('interim_eps', 20, 4)->nullable()->default(0);
            $table->string('interim_eps_period')->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
