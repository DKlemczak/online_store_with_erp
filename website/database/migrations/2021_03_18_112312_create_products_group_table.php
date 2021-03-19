<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_group', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->boolean('on_navbar');
            $table->foreignId('group_id')->nullable()->constrained('products_group')->cascade();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_group');
    }
}
