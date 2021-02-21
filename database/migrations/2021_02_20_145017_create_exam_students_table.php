<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_students', function (Blueprint $table) {
            $table->id();
            $table->integer('exam_id');
            $table->integer('user_id');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->tinyInteger('is_attend')->default(0);
            $table->time('remaining_time')->nullable();
            $table->string('node_number');
            $table->string('result')->nullable();
            $table->string('ip_address')->nullable();
            $table->tinyInteger('student_status')->default(0);
            $table->tinyInteger('is_agree')->default(0);
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
        Schema::dropIfExists('exam_students');
    }
}
