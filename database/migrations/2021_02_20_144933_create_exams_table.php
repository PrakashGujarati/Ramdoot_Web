<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->string('name');
            $table->text('note');
            $table->string('time_duration');
            $table->date('exam_date');
            $table->string('total_marks');
            $table->string('total_question');
            $table->string('group_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->tinyInteger('exam_status')->default(0);
            $table->tinyInteger('instant_result');
            $table->tinyInteger('is_minus_system')->default(0);
            $table->string('negative_marks')->nullable();
            $table->enum('status',["Active","Inactive","Deleted"])->default('Active')->nullable();
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
        Schema::dropIfExists('exams');
    }
}
