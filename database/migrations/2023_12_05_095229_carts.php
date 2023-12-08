<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->references('id')->on('users')->onDelete('cascade');;
            $table->foreignId('id_car')->constrained('cars')->references('id_car')->on('cars')->onDelete('cascade');;
            $table->string('carName');
            $table->integer('day');
            $table->integer('price');
            $table->date('pickup_date');
            $table->date('return_date');
            $table->string('location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
