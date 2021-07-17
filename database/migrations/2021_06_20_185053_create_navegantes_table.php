<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavegantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navegantes', function (Blueprint $table) {
            $table->char('id', 8)->primary();
            $table->string('nombres', 50);
            $table->string('telefono', 9);
            $table->string('email', 50)->nullable();
            $table->enum('estado', ['0','1']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('navegantes');
    }
}
