<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image')->default('imagen.jpg');
            $table->string('title')->nullable();
            $table->string('slug')->unique();
            $table->text('text')->nullable();
            $table->enum('button', [0, 1])->default(0);
            $table->string('button_text')->nullable();
            $table->string('pre_url')->nullable();
            $table->string('url')->nullable();
            $table->enum('target', [0, 1, 2])->default(0);
            $table->enum('type', [1])->default(1);
            $table->enum('state', [0, 1])->default(1);
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
        Schema::dropIfExists('banners');
    }
}
