<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brasindice extends Model
{
    use HasFactory;

    protected $connection = 'forge';

    protected $table = 'farmacia_importacoes.brasindice_medicamentos';

    protected $fillable = [
        'laboratorio_codigo',
        'laboratorio',
        'produto_codigo',
        'produto',
        'apresentacao_codigo',
        'apresentacao',
        'pmc',
        'pfb',
        'fracao',
        'tipo_fracao_pmc',
        'pmc_fracao',
        'tipo_pfb_fracao',
        'edicao_alteracao',
        'ipi',
        'portaria',
        'ean',
        'tiss',
        'generico',
        'tuss',
        'ggrem',
        'registro',
        'hierarquia',
        'aliquota_id',
        'versao_update',
        'tipo_brasindice',
        'restrito_hospitalar'
    ];
}
