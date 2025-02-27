<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('legal_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lease_id')->nullable()->constrained('leases')->onDelete('set null'); // Contrat lié
            $table->enum('type', ['bail', 'assurance', 'procédure judiciaire']);
            $table->string('file_path'); // Lien vers le fichier stocké
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_documents');
    }
};
