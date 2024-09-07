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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('cliente_nome', 100);
            $table->string('cliente_cpf', 14);
            $table->date('cliente_nascimento');
            $table->string('cliente_idade', 10);
            $table->string('cliente_telefone', 15);
            $table->integer('cliente_cidade_id');
            $table->integer('cliente_estado_id');
            $table->string('cliente_foto', 250);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
