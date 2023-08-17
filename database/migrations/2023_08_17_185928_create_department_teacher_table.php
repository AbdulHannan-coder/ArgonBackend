<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('department_teacher', function (Blueprint $table) {
            $table->id(); // Assuming you want an auto-incrementing primary key for this table
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('teacher_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('department_teacher');
    }
};
