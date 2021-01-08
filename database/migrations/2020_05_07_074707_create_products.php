<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
           $table->bigIncrements('id');
           $table->string('name',255);
           $table->integer('price');
           $table->integer('count');
           $table->string('description',255);
           $table->integer('activated')->default(0);
           $table->unsignedBigInteger('user_id');
           $table->unsignedBigInteger('category_id');
           $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
           $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
