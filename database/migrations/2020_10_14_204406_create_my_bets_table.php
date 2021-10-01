<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_bets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable()->default(0);
            $table->integer('match_id')->nullable()->default(0);
            $table->string('bet_type')->nullable()->default(null);
            $table->string('bet_side')->nullable()->default(null);
            $table->string('bet_odds')->nullable()->default(null);
            $table->string('bet_amount')->nullable()->default(null);
            $table->string('team_name')->nullable()->default(null);
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
        Schema::dropIfExists('my_bets');
    }
}
