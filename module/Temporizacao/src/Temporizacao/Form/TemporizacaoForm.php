<?php

namespace Temporizacao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class TemporizacaoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('temporizacaoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('temporizacaoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_temporizacao")->required(false)->label("Temporização");
      
       


        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}