<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLockUnlockBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lock_unlock_bets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lockType')->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(0);
            $table->integer('sportID')->nullable()->default(0);
            $table->string('match_id')->nullable()->default(0);
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
        Schema::dropIfExists('lock_unlock_bets');
    }
}
