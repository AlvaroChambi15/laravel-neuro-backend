<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer("numero");
            $table->string("titulo", 50);
            $table->string("portada");
            $table->boolean("showPortada")->default(true);
            // TODO: La descripción debe tener un numero limitado de caracteres
            $table->string("descripcion")->nullable();

            // UNIDAD TEMATICA
            $table->bigInteger("unit_id")->unsigned();
            $table->foreign("unit_id")->references("id")->on("units");

            // USUARIOS
            $table->bigInteger("user_id")->unsigned();
            $table->foreign("user_id")->references("id")->on("users");

            $table->softDeletes();
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
        Schema::dropIfExists('posts');
    }
};