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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('sitename')->nullable();
            $table->string('hotline')->nullable();
            $table->json('address')->nullable();
            $table->json('social_midea')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('hotline_img')->nullable();
            $table->string('email')->nullable();
            $table->json('phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
