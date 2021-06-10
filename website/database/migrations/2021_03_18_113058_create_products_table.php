<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->uuid('uuid')->unique();
            $table->string('code', 100);
            $table->integer('amount');
            $table->float('price',8,2);
            $table->longText('description')->nullable();
            $table->boolean('is_active');
            $table->foreignId('group_id')->constrained('products_group');
            $table->integer('discount');
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
