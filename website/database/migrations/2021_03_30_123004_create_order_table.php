<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')->unique();
            $table->string('city')->nullable();
            $table->string('post_code')->nullable();
            $table->string('street')->nullable();
            $table->string('building_number')->nullable();
            $table->string('email')->nullable();
            $table->float('value',8,2)->nullable();
            $table->foreignId('transport_id')->constrained('transport_type');
            $table->foreignId('payment_id')->constrained('payment_type');
            $table->foreignId('user_id')->constrained('users');
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
