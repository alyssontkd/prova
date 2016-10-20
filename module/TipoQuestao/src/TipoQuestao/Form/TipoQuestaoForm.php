<?php

namespace TipoQuestao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class TipoQuestaoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('tipoquestaoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('tipoquestaoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->text("nm_tipo_questao")->required(false)->label("Novo tipo de questão");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}