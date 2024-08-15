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
        Schema::create('student_subject_wise_scores', function (Blueprint $table) {
            $table->id();
            $table->string('student_name')->nullable();
            $table->string('subject')->nullable();
            $table->smallInteger('marks')->nullable();
            $table->tinyInteger('record_active')->default(1);
            $table->tinyInteger('record_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student__subject__wise__scores');
    }
};
