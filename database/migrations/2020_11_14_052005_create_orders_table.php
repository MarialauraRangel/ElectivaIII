<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->unique();
            $table->float('subtotal', 10, 2)->default(0.00)->unsigned();
            $table->float('discount', 10, 2)->default(0.00)->unsigned();
            $table->float('total', 10, 2)->default(0.00)->unsigned();
            $table->float('fee', 10, 2)->default(0.00)->unsigned();
            $table->float('balance', 10, 2)->default(0.00)->unsigned();
            $table->string('phone');
            $table->string('address');
            $table->enum('state', [0, 1, 2])->default(2);
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('coupon_id')->unsigned()->nullable();
            $table->bigInteger('payment_id')->unsigned()->nullable();
            $table->timestamps();

            #Relations
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
