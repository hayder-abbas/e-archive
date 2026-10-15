<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('number', 50);
            $table->string('subject');
            $table->date('date');
            $table->string('file')->nullable();
            $table->enum('type', ['Incoming', 'Outgoing']);
            $table->enum('security', ['Normal', 'Secure']);
            $table->text('description')->nullable();
            $table->foreignId('box_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('entity_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docs');
    }
};
