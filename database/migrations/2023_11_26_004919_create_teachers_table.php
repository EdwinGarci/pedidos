<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('email', 100);
            $table->enum('civil_status', ['Soltero', 'Casado', 'Viudo', 'Divorciado']);
            $table->string('faculty', 100); // Replace with actual faculty names
            $table->string('faculty_department', 100); // Replace with actual department names
            $table->string('category',100); // Replace with actual category names
            $table->string('codality', 100); // Replace with actual codality names
            $table->string('job_title', 100); // Replace with actual job titles
            $table->string('condition', 100); // Replace with actual conditions
            $table->string('professional_grade', 100); // Replace with actual professional grades
            $table->date('date_of_admission');
            $table->enum('teacher_status', ['Active', 'Renuncio', 'Fallecido']);
            $table->unsignedBigInteger('person_id');
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('person');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
