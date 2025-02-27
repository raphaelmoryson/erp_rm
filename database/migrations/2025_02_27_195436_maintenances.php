<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade'); // Lien avec le lot
            $table->foreignId('technician_id')->nullable()->constrained('users')->onDelete('set null');

            $table->text('issue'); // Description du problème
            $table->enum('status', ['en attente', 'en cours', 'résolu'])->default('en attente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('maintenances', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['technician_id']);
        });

        Schema::dropIfExists('maintenances');
    }

};

