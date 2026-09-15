<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();

            // Personal information
            $table->string('name');
            $table->date('date_of_birth')->nullable();
            $table->string('class_name')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('users')->nullOnDelete();

            // Academic information
            $table->string('subject')->nullable();
            $table->string('term')->nullable();
            $table->decimal('score', 5, 2)->nullable();

            // Behavioral information
            $table->string('category')->nullable();
            $table->text('behavior_note')->nullable();
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};