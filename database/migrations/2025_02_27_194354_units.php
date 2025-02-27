<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade'); // Lien avec l'immeuble
            $table->enum('type', ['appartement', 'bureau', 'commerce']);
            $table->float('surface');
            $table->enum('status', ['libre', 'loué', 'en travaux'])->default('libre');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropForeign(['property_id']);
        });

        Schema::dropIfExists('units');
    }

};
