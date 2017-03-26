<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyStatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistic_daily', function (Blueprint $table) {
            $table->date('date')->primary("date");
            $table->decimal("debit", 10, 2);
            $table->decimal("credit", 10, 2);
            $table->decimal("income", 10, 2);
            $table->decimal("expense", 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistic_daily');
    }
}
