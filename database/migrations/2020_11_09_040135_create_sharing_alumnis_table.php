<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharingAlumnisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sharing_alumnis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('alumni_id')->unsigned();
            $table->string('foto');
            $table->text('deskripsi');
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
        Schema::dropIfExists('sharing_alumnis');
    }
}
