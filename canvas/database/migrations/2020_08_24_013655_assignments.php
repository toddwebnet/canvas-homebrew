<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Assignments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assignment_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('student_id');
            $table->string('name');
            $table->dateTimeTz('due_at')->nullable();
            $table->timestamps();
            $table->foreign('course_id')->references('course_id')->on('courses');
            $table->foreign('student_id')->references('id')->on('students');
        });


        Schema::create('assignment_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assignment_id');
            $table->boolean('overdue_flag')->default(false);
            $table->boolean('unsubmitted_flag')->default(false);
            $table->boolean('latest')->default(true);
            $table->date('download_date');
            $table->timestamps();
            $table->foreign('assignment_id')->references('id')->on('assignments');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignment_status');
        Schema::dropIfExists('assignments');
    }
}
