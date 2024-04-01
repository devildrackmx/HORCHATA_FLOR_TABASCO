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
        Schema::create('revoltura_insumo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('revoltura_id');
            $table->unsignedBigInteger('insumo_id');
            $table->decimal('cantidad', 9, 3);
            $table->timestamps();

            $table->foreign('revoltura_id')->references('id')->on('revolturas')->onDelete('cascade');
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revoltura_insumo');
    }
};
