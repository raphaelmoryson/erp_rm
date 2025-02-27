<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade'); // Lot concerné
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade'); // Locataire
            $table->date('start_date'); // Date de début du contrat
            $table->date('end_date')->nullable(); // Date de fin (peut être null si contrat en cours)
            $table->decimal('deposit_amount', 10, 2); // Montant du dépôt de garantie
            $table->enum('status', ['actif', 'résilié', 'en cours'])->default('en cours');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leases');
    }
};
