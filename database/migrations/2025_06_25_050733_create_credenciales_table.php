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
        Schema::create('credenciales', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('foto_qr')->nullable();
            $table->string('fecha_emicion');
            $table->string('fecha_expiracion');
            $table->boolean('estado')->default(true);
            // $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('usuario_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('gestion_id')->constrained('gestiones')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credenciales');
    }
};
