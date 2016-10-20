<?php

namespace HistoricoAlternativasQuestao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class HistoricoAlternativasQuestaoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('historicoalternativasquestaoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('historicoalternativasquestaoform',$this,$this->inputFilter);

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}