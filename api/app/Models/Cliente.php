<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'id', 
        'cliente_nome', 
        'cliente_cpf', 
        'cliente_nascimento', 
        'cliente_idade',
        'cliente_telefone', 
        'cliente_cidade_id', 
        'cliente_estado_id', 
        'cliente_foto', 
        'created_at', 
        'updated_at'
    ];
}
