<?php

namespace AssuntoMateria\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class AssuntoMateriaForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('assuntomateriaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('assuntomateriaform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_materia", '\Materia\Service\MateriaService', 'id', 'nm_materia','filtraMateriaAtiva')->required(true)->label("Matéria");
        $objForm->text("nm_assunto_materia")->required(true)->label("Assunto");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}