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
            $table->date('date');
            $table->string('subject');
            $table->string('file')->nullable();
            $table->longText('content')->nullable();
            $table->enum('type', ['Incoming', 'Outgoing']);
            $table->enum('security', ['Normal', 'Secure']);
            $table->string('belongs_to', 50)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->foreignId('box_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('entity_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->timestamps();

            $table->primary(['id', 'number', 'date']);
            $table->fullText('content');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docs');
    }
};
