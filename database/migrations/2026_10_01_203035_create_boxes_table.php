<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boxes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number', 20);
            $table->date('date');
            $table->timestamps();

            $table->unique(['number', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boxes');
    }
};
