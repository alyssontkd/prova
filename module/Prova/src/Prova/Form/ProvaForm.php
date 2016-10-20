<?php

namespace Prova\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class ProvaForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('provaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('provaform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->hidden("id_usuario")->required(false)->label("Id Usuario");  
        $objForm->text("nm_prova")->required(false)->label("Nome da Prova");
        $objForm->textareaHtml("ds_prova")->required(false)->label("Instruções");
        $objForm->dateTime("dt_geracao_prova")->required(false)->setAttribute('class', 'data')->label("Data de Geração");
        $objForm->date("dt_aplicacao_prova")->required(false)->setAttribute('class', 'data')->label("Data de Aplicação");
       


        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}