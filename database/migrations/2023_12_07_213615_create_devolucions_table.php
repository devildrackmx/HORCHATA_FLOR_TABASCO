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
        Schema::create('devolucions', function (Blueprint $table) {
            $table->id();

            $table->date('fecha_devolucion');
            $table->string('numero_orden');
            $table->unsignedBigInteger('proveedor_id');
            $table->enum('estado', ['En proceso', 'Devuelto'])->default('En proceso');
            $table->enum('tipo_compra', ['CREDITO', 'CONTADO']);
            $table->enum('tipo_moneda', ['US', 'MXN']);
            $table->decimal('subtotal', 10, 2)->default(0); // Nuevo campo para el subtotal
            $table->integer('iva')->nullable(); // Nuevo campo para el IVA
            $table->decimal('total', 10, 2)->default(0); // Nuevo campo para el total

            $table->timestamps();

            $table->foreign('proveedor_id')->references('id')->on('proveedors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devolucions');
    }
};
