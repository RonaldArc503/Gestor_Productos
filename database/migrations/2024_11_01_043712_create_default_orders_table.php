<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_orders', function (Blueprint $table) {
            $table->id(); // ID único
            $table->unsignedBigInteger('product_id'); // ID del producto (relación)
            $table->integer('quantity'); // Cantidad
            $table->string('recipient'); // Correo del destinatario
            $table->decimal('price', 10, 2); // Precio del producto
            $table->timestamps(); // Campos created_at y updated_at
            
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('default_orders');
    }
}
