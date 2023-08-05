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
        Schema::create('sheets', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('id_number');



            $table->string('state');
            $table->string('state_ar');

            $table->string('title1');
            $table->string('title1_ar');
            $table->string('title2');
            $table->string('title2_ar');
            $table->string('title3');
            $table->string('title3_ar');

            $table->string('year');
            $table->string('year_ar');

            $table->string('school');
            $table->string('school_ar');

            $table->string('name');
            $table->string('name_ar');
            
            $table->string('class');

            $table->string('nationality');
            $table->string('nationality_ar');

            $table->string('birth_day');
            $table->string('birth_day_ar');



            $table->longText('table');

            $table->string('sort_by_grade')->nullable();
            $table->string('sort_by_class')->nullable();

            $table->string('absence')->nullable();
            $table->string('latency')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sheets');
    }
};
