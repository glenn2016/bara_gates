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
        Schema::table('evaluation_question_reponse_evaluations', function (Blueprint $table) {
            //
            $table->string('commentaire');
            $table->string('niveau');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluation_question_reponse_evaluations', function (Blueprint $table) {
            //
        });
    }
};
