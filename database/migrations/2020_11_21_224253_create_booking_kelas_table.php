<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_kelas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kelas_alumni_id')->unsigned();
            $table->bigInteger('alumni_id')->unsigned();
            $table->string('email');
            $table->string('nama_lengkap');
            $table->string('whatsapp');            
            $table->timestamps();

            $table->foreign('kelas_alumni_id')->references('id')->on('kelas_alumnis')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('booking_kelas');
    }
}
