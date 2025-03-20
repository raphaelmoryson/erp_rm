<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('company_id')->constrained('company')->onDelete('cascade');
            $table->text('description');
            $table->string('photo')->nullable();
            $table->string('linkUrl')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'refused', 'abandoned'])->default('pending');
            $table->timestamps();
        });

        Schema::create('report_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['progress', 'document'])->default('progress');
            $table->text('detail')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('report_lines');
        Schema::dropIfExists('reports');
    }
};
