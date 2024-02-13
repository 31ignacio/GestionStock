<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rembourssements', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->integer('montant');
            $table->text('mode');
            $table->unsignedBigInteger('facture_id');
            $table->foreign('facture_id')->references('id')->on('factures');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rembourssements');
    }
};
