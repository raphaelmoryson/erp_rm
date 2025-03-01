<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class tenants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id(); // ID unique pour chaque locataire
            $table->string('lastName'); // Nom du locataire
            $table->string('firstName'); // Prénom du locataire
            $table->string('email')->unique(); // Email unique
            $table->string('mobile'); // Numéro de téléphone
            $table->string('adress'); // Adresse du locataire
            $table->enum('status', ['actif', 'inactif', 'resilié'])->default('actif'); // Statut du locataire
            $table->timestamps(); // Création des champs 'created_at' et 'updated_at'
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenants');
    }
}
