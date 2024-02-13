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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->float('quantite');
            $table->dateTime('date');
            $table->integer('prix');
            $table->integer('total');
            $table->text('code');
            $table->integer('totalHT');
            $table->integer('totalTVA');
            $table->integer('totalTTC');
            $table->text('produit');
            $table->integer('montantPaye')->nullable();
            $table->integer('montantDu')->nullable();
            $table->integer('dette')->nullable();

            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->unsignedBigInteger('mode_id');
            $table->foreign('mode_id')->references('id')->on('mode_paiements')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
