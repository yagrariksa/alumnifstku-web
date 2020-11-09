<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomentarSharingAlumnisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komentar_sharing_alumnis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('alumni_id')->unsigned();
            $table->bigInteger('sharing_alumni_id')->unsigned();
            $table->text('text');
            $table->timestamps();

            $table->foreign('alumni_id')->references('id')->on('alumnis')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sharing_alumni_id')->references('id')->on('sharing_alumnis')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('komentar_sharing_alumnis');
    }
}
