<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id(); // Définition de l'ID de l'unité
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade'); // Lien avec l'immeuble
            $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade'); // Lien avec le locataire
            
            $table->enum('type', ['appartement', 'bureau', 'commerce']);
            $table->float('surface');
            $table->enum('status', ['libre', 'loué', 'en travaux'])->default('libre');
            $table->string('floor');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropForeign(['property_id']);
            $table->dropForeign(['tenant_id']);
        });

        Schema::dropIfExists('units');
    }
};
