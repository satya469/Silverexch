<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDepositesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_deposites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('deposite_user_id')->nullable()->default(0);
            $table->integer('withdrawal_user_id')->nullable()->default(0);
            $table->string('amount')->nullable()->default(null);
            $table->text('note')->nullable()->default(null);
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
        Schema::dropIfExists('user_deposites');
    }
}
