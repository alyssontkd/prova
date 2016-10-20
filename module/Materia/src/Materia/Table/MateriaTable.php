<?php

namespace Materia\Table;

use Estrutura\Table\AbstractEstruturaTable;

class MateriaTable extends AbstractEstruturaTable{

    public $table = 'materia';
    public $campos = [
        'id_materia'=>'id',
        'nm_materia'=>'nm_materia',


    ];

}