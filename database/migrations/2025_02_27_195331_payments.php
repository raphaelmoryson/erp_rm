<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade'); // Lien avec la facture
            $table->decimal('amount', 10, 2); // Montant du paiement
            $table->date('payment_date'); // Date du paiement
            $table->enum('method', ['virement', 'carte', 'qr_bill']); // Moyen de paiement
            $table->enum('status', ['validé', 'en attente', 'refusé'])->default('en attente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
