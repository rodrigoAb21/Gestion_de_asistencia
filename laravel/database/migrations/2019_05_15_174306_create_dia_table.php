<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dia', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('entrada');
            $table->string('salida');
            $table->boolean('visible')->default(true);

            $table->unsignedInteger('horario_id');
            $table->foreign('horario_id')->references('id')->on('horario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dia');
    }
}
