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
        Schema::create('subject', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sheet_id');
            $table->string('subject');
            $table->string('subject_ar');
            $table->float('grade_short')->nullable();
            $table->float('total');
            $table->string('status'); // 0->fail | 1-> good | 2-> best
            $table->string('rank'); //  1-> 60 | 2-> 100
            $table->string('grade');
            $table->string('Evaluation')->nullable();
            $table->string('end_period')->nullable();
            // Add foreign key constraint to link the subscription to the user
            $table->foreign('sheet_id')->references('id')->on('sheets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject');
    }
};
