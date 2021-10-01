<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchFanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_fancies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('match_id')->nullable()->default(0);
            $table->string('fancyType')->nullable()->default(null);
            $table->string('fancyName')->nullable()->default(null);
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
        Schema::dropIfExists('match_fancies');
    }
}
