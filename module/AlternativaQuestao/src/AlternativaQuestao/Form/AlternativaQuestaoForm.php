<?php

namespace AlternativaQuestao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class AlternativaQuestaoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('alternativaquestaoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('alternativaquestaoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");

        $objForm->hidden("id_questao")->required(false)->label("Id Questao");
        $objForm->textareaHtml("tx_alternativa_questao")->required(false)->label("Enunciado da Alternativa");
        $objForm->select("cs_correta", array('C' => 'Correta', 'E'=>'Errada'))->required(false)->label("Resposta");
        $objForm->textareaHtml("tx_justificativa")->required(false)->label("Justificativa da Alternativa");
        $objForm->text("tx_caminho_imagem_alternativa")->required(false)->label("Caminho da Imagem");
        $objForm->combo("id_usuario_cadastro", '\Usuario\Service\UsuarioService', 'id', 'nm_usuario')->required(false)->label("Usuario");
        $objForm->combo("id_usuario_alteracao", '\Usuario\Service\UsuarioService', 'id', 'nm_usuario')->required(false)->label("Usuario");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}