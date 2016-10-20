<?php

namespace Classificacao\Table;

use Estrutura\Table\AbstractEstruturaTable;

class ClassificacaoTable extends AbstractEstruturaTable{

    public $table = 'classificacao_semestre';
    public $campos = [
        'id_classificacao_semestre'=>'id',
        'nm_classificacao_semestre'=>'nm_classificacao_semestre',
        
    ];

}