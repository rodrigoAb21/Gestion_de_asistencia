<?php

use App\Ubicacion;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUbicacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ubicacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('direccion');
            $table->string('telefono');
            $table->double('latitud');
            $table->double('longitud');
            $table->boolean('visible')->default(true);

        });

        $central = new Ubicacion();
        $central->nombre = 'Oficina Central';
        $central->direccion = 'Doble via La Guardia km 9';
        $central->telefono = '3548690';
        $central->latitud = -63.865456;
        $central->longitud = -17.6845564;
        $central->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ubicacion');
    }
}
