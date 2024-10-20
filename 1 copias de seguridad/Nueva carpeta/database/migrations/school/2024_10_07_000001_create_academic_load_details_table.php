<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicLoadDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('academic_load_details', function (Blueprint $table) {
            $table->id();
            $table->string('course_name');
            $table->string('teacher_name');
            $table->integer('semester');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('academic_load_details');
    }
}

