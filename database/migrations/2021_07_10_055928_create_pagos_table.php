<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tupa_id');
            $table->char('navegante_id');
            $table->string('num_op', 20);
            $table->decimal('monto', 8,2);
            $table->enum('estado',['0','1','2', '3']); //0 = enviado, 1 = aceptado, 2 = rechazado
            $table->string('mensaje')->nullable();
            $table->string('archivo');
            $table->timestamps();

            // $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('navegante_id')->references('id')->on('navegantes')->onDelete('cascade');
            $table->foreign('tupa_id')->references('id')->on('tupas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos');
    }
}
