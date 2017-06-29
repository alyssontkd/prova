<?php

namespace MateriaSemestre\Table;

use Estrutura\Table\AbstractEstruturaTable;

class MateriaSemestreTable extends AbstractEstruturaTable{

    public $table = 'materia_semestre';
    public $campos = [
        'id_materia_semestre'=>'id',
        'id_classificacao_semestre'=>'id_classificacao_semestre',
        'id_materia'=> 'id_materia',
        'cs_ativo'=>'cs_ativo',


    ];

}