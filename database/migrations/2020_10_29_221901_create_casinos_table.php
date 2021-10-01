<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasinosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casinos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sportID')->nullable()->default(0);
            $table->integer('roundID')->nullable()->default(0);
            $table->text('card1')->nullable()->default(null);
            $table->text('card2')->nullable()->default(null);
            $table->text('card3')->nullable()->default(null);
            $table->text('card4')->nullable()->default(null);
            $table->string('result')->nullable()->default(null);
            $table->string('status')->nullable()->default(null);
            $table->text('extra')->nullable()->default(null);
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
        Schema::dropIfExists('casinos');
    }
}
