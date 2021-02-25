<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('board_id')->default(0);
            $table->unsignedBigInteger('standard_id')->default(0);
            $table->unsignedBigInteger('semester_id')->default(0);
            $table->unsignedBigInteger('subject_id')->default(0);
            $table->unsignedBigInteger('unit_id')->default(0);
            $table->unsignedBigInteger('user_id')->default(0);
            $table->string('question',255)->nullable();
            $table->string('answer',255)->nullable();
            $table->string('marks',500)->nullable();
            $table->string('image',500)->nullable();
            $table->string('label',255)->nullable();
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
        Schema::dropIfExists('solutions');
    }
}
