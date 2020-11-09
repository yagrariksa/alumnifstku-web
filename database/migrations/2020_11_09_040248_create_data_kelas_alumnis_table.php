<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKelasAlumnisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_kelas_alumnis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kelas_alumni_id')->unsigned();
            $table->string('pembicara');
            $table->string('tentang');
            $table->string('foto');
            // $table->timestamps();
            
            $table->foreign('kelas_alumni_id')->references('id')->on('kelas_alumnis')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_kelas_alumnis');
    }
}
