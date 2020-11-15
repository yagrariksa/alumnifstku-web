<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiodataAlumnisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biodata_alumnis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('alumni_id')->unsigned();
            $table->string('nama');
            $table->integer('angkatan');
            $table->string('jurusan');
            $table->string('linkedin')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('alumni_id')->references('id')->on('alumnis')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('biodata_alumnis');
    }
}
