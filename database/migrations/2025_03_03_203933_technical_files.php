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
        Schema::create('technical_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('technical_folder_id')->constrained()->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('technical_files', function (Blueprint $table) {
            // Utilise le vrai nom trouvé dans SHOW CREATE TABLE
            $table->dropForeign('nom_correct_de_la_contrainte');
            $table->dropColumn('technical_folder_id');
        });
    }
    
};
