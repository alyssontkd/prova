<?php

namespace NivelDificuldade\Table;

use Estrutura\Table\AbstractEstruturaTable;

class NivelDificuldadeTable extends AbstractEstruturaTable{

    public $table = 'nivel_dificuldade';
    public $campos = [
        'id_nivel_dificuldade'=>'id',
        'nm_nivel_dificuldade'=>'nm_nivel_dificuldade',
        'cs_ativo'=>'cs_ativo',
    ];

}