<?php

namespace FonteQuestao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class FonteQuestaoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('fontequestaoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('fontequestaoform',$this,$this->inputFilter);

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}