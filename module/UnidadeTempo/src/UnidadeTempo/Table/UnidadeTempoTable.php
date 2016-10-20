<?php

namespace UnidadeTempo\Table;

use Estrutura\Table\AbstractEstruturaTable;

class UnidadeTempoTable extends AbstractEstruturaTable{

    public $table = 'unidade_tempo';
    public $campos = [
        'id_unidade_tempo'=>'id',
        'nm_unidade_tempo'=>'nm_unidade_tempo',
        
    ];

}