<?php

use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('huella')->nullable();
            $table->string('foto')->nullable();
            $table->string('direccion');
            $table->string('telefono');
            $table->boolean('visible')->default(true);
            $table->rememberToken();

            $table->unsignedInteger('rol_id');
            $table->foreign('rol_id')->references('id')->on('rol');

            $table->unsignedInteger('ubicacion_id');
            $table->foreign('ubicacion_id')->references('id')->on('ubicacion');


        });

        $admin = new User();
        $admin->nombre = 'Rodrigo Abasto';
        $admin->huella = '';
        $admin->foto = '';
        $admin->direccion = 'Radial 17 1/2 6to anillo';
        $admin->telefono = '3532021';
        $admin->email = 'rodrigo@gmail.com';
        $admin->password = bcrypt('rodrigo');
        $admin->rol_id = 1;
        $admin->ubicacion_id = 1;
        $admin->save();



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
