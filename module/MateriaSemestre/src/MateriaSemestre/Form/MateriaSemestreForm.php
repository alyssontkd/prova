<?php

namespace MateriaSemestre\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class MateriaSemestreForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('materiasemestreform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('materiasemestreform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_classificacao_semestre", '\Classificacao\Service\ClassificacaoService', 'id', 'nm_classificacao_semestre')->required(true)->label("Semestre");
        $objForm->combo("id_materia", '\Materia\Service\MateriaService', 'id', 'nm_materia')->required(true)->label("Matéria");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}