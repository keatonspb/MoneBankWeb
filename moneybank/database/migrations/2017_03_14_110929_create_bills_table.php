<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("account_id", false, true)->references('id')->on('accounts')->onDelete('cascade');
            $table->integer("user_id", false, true)->references('id')->on('users')->onDelete('set null');
            $table->integer("reason_id", false, true)->references('id')->on('reasons')->onDelete('set null');
            $table->enum('type', array('income', 'expense'));
            $table->decimal("value", 10, 2);
            $table->boolean("credit")->default(false);
            $table->char("description")->nullable();
            $table->decimal("lat", 10 ,8)->index();
            $table->decimal("lng", 10 ,8)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
