<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('discount_id')->nullable();
            $table->string('name');
            $table->string('tags')->nullable();
            $table->string('keywords')->nullable();
            $table->bigInteger('price')->default(0);
            $table->bigInteger('market_price')->default(0);
            $table->boolean('status')->default(true);
            $table->text('desciption')->nullable();
            $table->string('use_icon')->nullable();
            $table->dateTime('use_icon_period_from')->nullable();
            $table->dateTime('use_icon_period_to')->nullable();
            $table->text('images')->nullable();
            $table->enum('visible', ['Y', 'N'])->default('Y');
            $table->enum('use_slideshow', ['Y', 'N'])->default('Y');
            $table->integer('number_view')->default(0);
            $table->integer('number_like')->default(0);
            $table->integer('number_bookmark')->default(0);
            $table->integer('number_share')->default(0);
            $table->integer('number_item')->default(0);
            $table->softDeletes();
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
        Schema::drop('products');
    }

}
