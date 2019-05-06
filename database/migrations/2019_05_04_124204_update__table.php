<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Создадим заново таблицу
        Schema::table('bills', function (Blueprint $table) {
            Schema::dropIfExists('bills');
        });
        Schema::create('bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('number');
            $table->smallInteger('status');
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
        Schema::table('bills', function (Blueprint $table) {
            Schema::dropIfExists('bills');
        });
    }
}
