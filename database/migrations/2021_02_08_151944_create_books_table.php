<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('board_id')->default(0);
            $table->unsignedBigInteger('standard_id')->default(0);
            $table->unsignedBigInteger('semester_id')->default(0);
            $table->unsignedBigInteger('subject_id')->default(0);
            $table->unsignedBigInteger('unit_id')->default(0);
            $table->unsignedBigInteger('user_id')->default(0);
            $table->string('title',255)->nullable();
            $table->string('url',500)->nullable();
            $table->string('thumbnail',500)->nullable();
            $table->string('pages',255)->nullable();
            $table->text('description')->nullable();
            $table->string('label',255)->nullable();    
            $table->date('release_date')->nullable();
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
        Schema::dropIfExists('books');
    }
}
