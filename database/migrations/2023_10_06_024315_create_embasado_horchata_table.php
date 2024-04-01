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
        Schema::create('embasado_horchata', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('embasado_id');
            $table->unsignedBigInteger('horchata_id');
            $table->integer('num_cajas');

            $table->timestamps();

            $table->foreign('embasado_id')->references('id')->on('embasados')->onDelete('cascade');
            $table->foreign('horchata_id')->references('id')->on('horchatas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embasado_horchata');
    }
};
