<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifAlumnisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notif_alumnis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('alumni_id')->unsigned();
            $table->string('text');
            $table->boolean('is_read');   
            $table->datetime('readed_at');
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
        Schema::dropIfExists('notif_alumnis');
    }
}
