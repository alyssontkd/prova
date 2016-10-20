<?php

namespace HistoricoQuestoesProva\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class HistoricoQuestoesProvaForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('historicoquestoesprovaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('historicoquestoesprovaform',$this,$this->inputFilter);

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}