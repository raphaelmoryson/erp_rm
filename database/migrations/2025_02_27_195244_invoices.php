<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lease_id')->constrained('leases')->onDelete('cascade'); // Lien avec le bail
            $table->decimal('amount', 10, 2); // Montant de la facture
            $table->string('qr_code')->nullable(); // QR Swiss Bill
            $table->date('due_date'); // Date limite de paiement
            $table->enum('status', ['payée', 'en attente', 'impayée'])->default('en attente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
