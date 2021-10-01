<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users', function (Blueprint $table) {
        $table->string('city')->nullable()->default(null);
        $table->string('phone')->nullable()->default(null);
        $table->string('credit_ref')->nullable()->default(null);
        $table->string('exposelimit')->nullable()->default(null);
        $table->string('commission_cricket')->nullable()->default(null);
        $table->string('commission_football')->nullable()->default(null);
        $table->string('commission_tennic')->nullable()->default(null);
        $table->string('partnership_cricket')->nullable()->default(null);
        $table->string('partnership_football')->nullable()->default(null);
        $table->string('partnership_tennic')->nullable()->default(null);
        $table->string('minbet_cricket')->nullable()->default(null);
        $table->string('maxbet_cricket')->nullable()->default(null);
        $table->string('delay_cricket')->nullable()->default(null);
        $table->string('minbet_football')->nullable()->default(null);
        $table->string('maxbet_football')->nullable()->default(null);
        $table->string('delay_football')->nullable()->default(null);
        $table->string('minbet_tennic')->nullable()->default(null);
        $table->string('maxbet_tennic')->nullable()->default(null);
        $table->string('delay_tennic')->nullable()->default(null);
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('users', function (Blueprint $table) {
        $table->string('city')->nullable()->default(null);
        $table->string('phone')->nullable()->default(null);
        $table->string('credit_ref')->nullable()->default(null);
        $table->string('exposelimit')->nullable()->default(null);
        $table->string('commission_cricket')->nullable()->default(null);
        $table->string('commission_football')->nullable()->default(null);
        $table->string('commission_tennic')->nullable()->default(null);
        $table->string('partnership_cricket')->nullable()->default(null);
        $table->string('partnership_football')->nullable()->default(null);
        $table->string('partnership_tennic')->nullable()->default(null);
        $table->string('minbet_cricket')->nullable()->default(null);
        $table->string('maxbet_cricket')->nullable()->default(null);
        $table->string('delay_cricket')->nullable()->default(null);
        $table->string('minbet_football')->nullable()->default(null);
        $table->string('maxbet_football')->nullable()->default(null);
        $table->string('delay_football')->nullable()->default(null);
        $table->string('minbet_tennic')->nullable()->default(null);
        $table->string('maxbet_tennic')->nullable()->default(null);
        $table->string('delay_tennic')->nullable()->default(null);
      });
    }
}
