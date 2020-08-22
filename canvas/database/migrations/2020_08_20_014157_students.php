<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Students extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('family_id');
            $table->string('name');
            $table->string('school')->nullable();
            $table->string('grade')->nullable();
            $table->timestamps();
            $table->primary('id');
            $table->foreign('family_id')->references('id')->on('families');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
