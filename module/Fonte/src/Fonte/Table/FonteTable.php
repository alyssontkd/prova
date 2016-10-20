<?php

namespace Fonte\Table;

use Estrutura\Table\AbstractEstruturaTable;

class FonteTable extends AbstractEstruturaTable{

    public $table = 'fonte_questao';
    public $campos = [
        'id_fonte_questao'=>'id',
        'nm_fonte_questao'=>'nm_fonte_questao',
        
    ];

}