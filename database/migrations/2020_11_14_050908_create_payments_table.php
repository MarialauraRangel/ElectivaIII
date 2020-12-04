<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->unique();
            $table->string('subject');
            $table->float('total', 10, 2)->default(0.00)->unsigned();
            $table->float('fee', 10, 2)->default(0.00)->unsigned();
            $table->float('balance', 10, 2)->default(0.00)->unsigned();
            $table->enum('method', [1, 2, 3])->default(1);
            $table->string('currency');
            $table->enum('state', [0, 1, 2])->default(2);
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->timestamps();

            #Relations
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
