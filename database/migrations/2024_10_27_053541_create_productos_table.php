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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del producto
            $table->string('brand'); // Marca del producto
            $table->string('category'); // Categoría del producto
            $table->decimal('price', 10, 2); // Precio del product
            $table->integer('cantidad');
            $table->enum('stock', ['en stock', 'agotado'])->default('en stock'); // Estado del stock
            $table->timestamps(); // Campos de fecha y hora de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
