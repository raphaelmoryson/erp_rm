<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->decimal('amount', 10, 2); // Montant du paiement
            $table->enum('status', ['en attente', 'payé', 'retard', 'annulé'])->default('en attente');
            $table->date('due_date'); // Date limite de paiement
            $table->date('paid_at')->nullable(); // Date du paiement si payé
            $table->string('payment_method')->nullable(); // Ex: Virement, CB, Espèces
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
