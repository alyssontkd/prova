<?php

namespace UnidadeTempo\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class UnidadeTempoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('unidade_tempoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('unidade_tempoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_unidade_tempo")->required(false)->label("unidade_tempo");
      
       


        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}