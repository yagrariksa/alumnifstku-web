<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sharing_alumni_id')->unsigned();
            $table->integer('like_count');
            $table->integer('comment_count');
            // $table->timestamps();

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
        Schema::dropIfExists('post_attributes');
    }
}
