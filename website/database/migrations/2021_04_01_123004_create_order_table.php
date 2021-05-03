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
            $table->string('user_name');
            $table->string('user_surname');
            $table->string('document_number')->unique();
            $table->string('city');
            $table->string('post_code');
            $table->string('street');
            $table->string('building_number');
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->float('value',8,2)->nullable();
            $table->foreignId('transport_id')->constrained('transport_type');
            $table->foreignId('payment_id')->constrained('payment_type');
            $table->foreignId('user_id')->nullable()->constrained('users');
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
