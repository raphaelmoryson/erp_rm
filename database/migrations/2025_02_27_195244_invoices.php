<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade'); // Lien avec le locataire
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade'); // Lien avec l'appartement
            $table->decimal('amount', 10, 2); // Montant total de la facture
            $table->string('qr_code')->nullable();
            $table->string('name')->nullable();
            $table->date('due_date'); 
            $table->enum('status', ['payée', 'en attente', 'impayée'])->default('en attente');
            $table->timestamps();
        });

        // Table des lignes de facture
        Schema::create('invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->string('description');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoice_lines');
    }
};
