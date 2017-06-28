<?php

namespace FiltroProva\Table;

use Estrutura\Table\AbstractEstruturaTable;

class FiltroProvaTable extends AbstractEstruturaTable{

    public $table = 'filtro_prova';
    public $campos = [
        'id_filtro_prova'=>'id',
        'id_prova'=>'id_prova',
        'id_tipo_questao'=>'id_tipo_questao',
        'id_fonte_questao'=>'id_fonte_questao',
        'id_assunto_materia'=>'id_assunto_materia',
        'id_nivel_dificuldade'=>'id_nivel_dificuldade',
        'id_classificacao_semestre'=>'id_classificacao_semestre',
        'nr_questoes'=>'nr_questoes',
        'cs_ativo'=>'cs_ativo',
    ];
}