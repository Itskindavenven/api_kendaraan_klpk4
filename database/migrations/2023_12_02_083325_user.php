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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('id_subs')->constrained('subscriptions')->references('id')->on('subscriptions')->onDelete('cascade');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('noTelp');
            $table->string('tglLahir');
            $table->longText('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
