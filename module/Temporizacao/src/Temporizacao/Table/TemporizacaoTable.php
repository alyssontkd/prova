<?php

namespace Temporizacao\Table;

use Estrutura\Table\AbstractEstruturaTable;

class TemporizacaoTable extends AbstractEstruturaTable{

    public $table = 'temporizacao';
    public $campos = [
        'id_temporizacao'=>'id',
        'nm_temporizacao'=>'nm_temporizacao',
        'id_unidade_tempo'=>'id_unidade_tempo',
        
    ];

}