<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('send_to_kitchen_time');
            $table->string('status')->default('Pending');
            $table->timestamps();
        });

        Schema::create('concession_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('concession_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('concession_order');
        Schema::dropIfExists('orders');
    }
};