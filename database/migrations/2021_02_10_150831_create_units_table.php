<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('standard_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('subject_id');
            $table->string('title',255)->nullable();
            $table->string('url',500)->nullable();
            $table->string('thumbnail',500)->nullable();
            $table->string('pages',255)->nullable();
            $table->string('description',255)->nullable();
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
        Schema::dropIfExists('units');
    }
}
