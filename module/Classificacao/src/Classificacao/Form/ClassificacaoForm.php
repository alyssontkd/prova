<?php

namespace Classificacao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class ClassificacaoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('classificacaoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('classificacaoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_classificacao_semestre")->required(false)->label("Classificacao");  
      
       


        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}