<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log; // Para registrar en los logs

class CrearUsuariosColegio extends Migration
{
    public function up()
    {
        Schema::create('usuarios_colegio', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('contraseña');
            $table->unsignedBigInteger('role_id'); // Este es el campo que agregaremos
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Log::info('Tabla usuarios_colegio creada correctamente.');
    }

    public function down()
    {
        Schema::dropIfExists('usuarios_colegio');

        Log::info('Tabla usuarios_colegio eliminada.');
    }
}
