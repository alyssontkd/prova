<?php

namespace Fonte\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class FonteForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('fonteform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('fonteform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_fonte_questao")->required(false)->label("Fonte");  
      
       


        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}