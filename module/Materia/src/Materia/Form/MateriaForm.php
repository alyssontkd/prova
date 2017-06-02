<?php

namespace Materia\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class MateriaForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('materiaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('materiaform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->text("nm_materia")->required(false)->label("Nova Matéria");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}