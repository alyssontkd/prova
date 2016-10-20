<?php

namespace ClassificacaoSemestre\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class ClassificacaoSemestreForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('classificacaosemestreform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('classificacaosemestreform',$this,$this->inputFilter);

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}