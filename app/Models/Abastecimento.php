<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abastecimento extends Model
{
    protected $table = 'abastecimentos';

    protected $fillable = [
        'data',
        'placa',
        'motorista',
        'tipo_combustivel',
        'quantidade',
        'valor',
    ];
}
