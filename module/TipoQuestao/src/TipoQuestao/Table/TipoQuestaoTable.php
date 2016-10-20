<?php

namespace TipoQuestao\Table;

use Estrutura\Table\AbstractEstruturaTable;

class TipoQuestaoTable extends AbstractEstruturaTable{

    public $table = 'tipo_questao';
    public $campos = [
        'id_tipo_questao'=>'id',
        'nm_tipo_questao'=>'nm_tipo_questao',


    ];

}