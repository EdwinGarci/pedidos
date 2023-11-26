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
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('relationship', 30);
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('person_id');
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->foreign('person_id')->references('id')->on('person');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
