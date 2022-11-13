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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->integer("orden");
            $table->string("tipo", 20);
            $table->longText("objeto")->nullable();
            $table->string("tipo_doc", 13)->nullable();
            $table->string("altura", 10)->nullable();
            $table->string("anchura", 10)->nullable();

            $table->bigInteger("post_id")->unsigned();
            $table->foreign("post_id")->references("id")->on("posts");

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
        Schema::dropIfExists('contents');
    }
};