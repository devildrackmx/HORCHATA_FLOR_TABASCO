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
        Schema::create('devolucion_insumo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('devolucion_id');
            $table->unsignedBigInteger('insumo_id');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('importe', 10, 2);

            $table->timestamps();

            $table->foreign('devolucion_id')->references('id')->on('devolucions')->onDelete('cascade');
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devolucion_insumo');
    }
};
