<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->onDelete('cascade'); // Liaison avec le report

            $table->string('description');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->date('scheduled_date')->nullable(); // Date prévue pour le travail
            $table->string('execution_deadline')->nullable(); // Priorité du travail
            $table->string('assigned_to')->nullable(); // Personne en charge des travaux
            $table->string('photo')->nullable(); // URL de la photo
            $table->string('document')->nullable(); // Lien vers un document complémentaire
            $table->decimal('quote_price', 10, 2)->nullable();
            $table->text('comments')->nullable(); // Notes supplémentaires

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
