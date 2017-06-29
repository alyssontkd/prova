<?php

namespace Prova\Table;

use Estrutura\Table\AbstractEstruturaTable;

class ProvaTable extends AbstractEstruturaTable{

    public $table = 'prova';
    public $campos = [
        'id_prova'=>'id',
        'nm_prova'=>'nm_prova',
        'id_usuario'=>'id_usuario',
        'dt_aplicacao_prova'=>'dt_aplicacao_prova',
        'dt_geracao_prova'=>'dt_geracao_prova',
        'tx_complemento'=>'tx_complemento',
        'ds_prova'=>'ds_prova',
        'cs_ativo'=>'cs_ativo',
    ];

}