<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->foreignId('mcq_id')->references('id')->on('mcqs')->onDelete('cascade');
            $table->foreignId('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->boolean('verdict');
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
        Schema::dropIfExists('answers');
    }
}
