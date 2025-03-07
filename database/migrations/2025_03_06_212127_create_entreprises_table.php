<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nom de l’entreprise
            $table->string('email')->unique(); // Email de contact
            $table->string('phone')->nullable(); // Téléphone
            $table->string('address')->nullable(); // Adresse
            $table->string('city')->nullable(); // Ville
            $table->string('zip_code')->nullable(); // Code postal
            $table->string('siren')->unique(); // Numéro d’identification SIREN (France) ou autre
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company');
    }
};
