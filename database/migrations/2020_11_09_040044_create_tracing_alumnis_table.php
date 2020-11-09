<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracingAlumnisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracing_alumnis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('alumni_id')->unsigned();
            $table->string('perusahaan');
            $table->integer('tahun_masuk');
            $table->string('jabatan');
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
        Schema::dropIfExists('tracing_alumnis');
    }
}
