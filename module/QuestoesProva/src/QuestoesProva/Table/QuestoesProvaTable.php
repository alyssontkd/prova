<?php

namespace QuestoesProva\Table;

use Estrutura\Table\AbstractEstruturaTable;

class QuestoesProvaTable extends AbstractEstruturaTable{

    public $table = 'questoes_prova';
    public $campos = [
        'id_questao_prova'=>'id',
        'id_questao'=>'id_questao',
        'id_prova'=>'id_prova',
    ];

}