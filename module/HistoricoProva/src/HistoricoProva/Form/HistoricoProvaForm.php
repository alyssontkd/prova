<?php

namespace HistoricoProva\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class HistoricoProvaForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('historicoprovaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('historicoprovaform',$this,$this->inputFilter);

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}