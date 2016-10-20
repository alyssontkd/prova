<?php

namespace QuestoesProva\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class QuestoesProvaForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('questoesprovaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('questoesprovaform',$this,$this->inputFilter);

        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_questao", '\Questao\Service\QuestaoService','id','nm_titulo_questao')->required(true)->label("Questao");
        $objForm->combo("id_prova", '\Prova\Service\ProvaService','id','nm_prova')->required(true)->label("Prova");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}