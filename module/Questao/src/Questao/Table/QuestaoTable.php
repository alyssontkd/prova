<?php

namespace Questao\Table;

use Estrutura\Table\AbstractEstruturaTable;

class QuestaoTable extends AbstractEstruturaTable{

    public $table = 'questao';
    public $campos = [
        'id_questao'=>'id',
        'id_usuario_cadastro'=>'id_usuario_cadastro',
        'id_usuario_alteracao'=>'id_usuario_alteracao',
        'id_classificacao_semestre'=>'id_classificacao_semestre',
        'id_nivel_dificuldade'=>'id_nivel_dificuldade',
        'id_temporizacao'=> 'id_temporizacao',
        'id_tipo_questao'=>'id_tipo_questao',
        'id_fonte_questao'=>'id_fonte_questao',
        'id_assunto_materia'=>'id_assunto_materia',
        'nm_titulo_questao'=>'nm_titulo_questao',
        'tx_enunciado'=>'tx_enunciado',
        'tx_caminho_imagem_questao'=>'tx_caminho_imagem_questao',
        'dt_cadastro'=>'dt_cadastro',
        'dt_alteracao'=>'dt_alteracao',
        'dt_ultima_utilizacao'=>'dt_ultima_utilizacao',
        'cs_ativo'=>'cs_ativo',
        'bo_utilizavel'=>'bo_utilizavel',
    ];

}