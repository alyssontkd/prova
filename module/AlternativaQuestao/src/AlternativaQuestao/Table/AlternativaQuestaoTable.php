<?php

namespace AlternativaQuestao\Table;

use Estrutura\Table\AbstractEstruturaTable;

class AlternativaQuestaoTable extends AbstractEstruturaTable
{

    public $table = 'alternativa_questao';
    public $campos = [
        'id_alternativa_questao' => 'id',
        'id_usuario_cadastro' => 'id_usuario_cadastro',
        'id_usuario_alteracao' => 'id_usuario_alteracao',
        'id_questao' => 'id_questao',
        'tx_alternativa_questao' => 'tx_alternativa_questao',
        'tx_caminho_imagem_alternativa' => 'tx_caminho_imagem_alternativa',
        'cs_correta' => 'cs_correta',
        'tx_justificativa' => 'tx_justificativa',
        'dt_cadastro' => 'dt_cadastro',
        'dt_alteracao' => 'dt_alteracao',
    ];

}