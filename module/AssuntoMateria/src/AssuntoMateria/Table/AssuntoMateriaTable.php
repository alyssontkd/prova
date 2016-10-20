<?php

namespace AssuntoMateria\Table;

use Estrutura\Table\AbstractEstruturaTable;

class AssuntoMateriaTable extends AbstractEstruturaTable{

    public $table = 'assunto_materia';
    public $campos = [
        'id_assunto_materia'=>'id',
        'id_materia'=> 'id_materia',
        'nm_assunto_materia'=>'nm_assunto_materia',


    ];

}