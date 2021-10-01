<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpperLevelDownLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upper_level_down_levels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable()->default(0);
            $table->integer('bet_user_id')->nullable()->default(0);
            $table->integer('deposit_id')->nullable()->default(0);
            $table->integer('sportID')->nullable()->default(0);
            $table->string('matchID')->nullable()->default(null);
            $table->string('per')->nullable()->default(null);
            $table->string('upperLevel')->nullable()->default(null);
            $table->string('downLevel')->nullable()->default(null);
            $table->integer('active')->nullable()->default(1);
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
        Schema::dropIfExists('upper_level_down_levels');
    }
}
