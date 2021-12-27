<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesProductsAll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50)->nullable(false); 
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();           
        });

        Schema::create('tag', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50)->nullable(false);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();                       
        });

        Schema::create('produto_tag', function (Blueprint $table) { 
            $table->id();           
            $table->unsignedBigInteger('produto_id');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('produto_id')->references('id')->on('produto');
            $table->foreign('tag_id')->references('id')->on('tag');
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
        Schema::dropIfExists('product');
        Schema::dropIfExists('tag');
        Schema::dropIfExists('product_tag');
    }
}
