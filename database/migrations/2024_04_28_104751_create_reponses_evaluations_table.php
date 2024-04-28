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
        Schema::create('reponses_evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            
            $table->unsignedBigInteger('questions_evaluations_id')->nullable();
            $table->foreign('questions_evaluations_id')->references('id')->on('questions_evaluations')->onDelete('cascade')->nullable();

            $table->unsignedBigInteger('evaluatuer_id')->nullable();
            $table->foreign('evaluatuer_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('evaluer_id')->nullable();
            $table->foreign('evaluer_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reponses_evaluations');
    }
};
