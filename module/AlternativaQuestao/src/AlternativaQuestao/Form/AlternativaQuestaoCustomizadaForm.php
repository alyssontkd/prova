<?php

namespace AlternativaQuestao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class AlternativaQuestaoCustomizadaForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('alternativaquestaoCustomizadaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('alternativaquestaoCustomizadaform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");

        $objForm->hidden("id_questao")->required(false)->label("Id Questao");
        $objForm->combo("id_fonte_questao", '\Fonte\Service\FonteService','id','nm_fonte_questao')->required(true)->label("Selecionar a fonte");
        $objForm->combo("id_classificacao_semestre", '\Classificacao\Service\ClassificacaoService','id','nm_classificacao_semestre')->required(true)->label("Classificacao do semestre");
        $objForm->combo("id_nivel_dificuldade", '\NivelDificuldade\Service\NivelDificuldadeService','id','nm_nivel_dificuldade')->required(true)->label("Nivel de Dificuldade");
        $objForm->combo("id_temporizacao", '\Temporizacao\Service\TemporizacaoService','id','nm_temporizacao')->required(true)->label("Temporizador");
        $objForm->combo("id_tipo_questao", '\TipoQuestao\Service\TipoQuestaoService','id','nm_tipo_questao')->required(true)->label("Tipo");
        $objForm->combo("id_materia", '\Materia\Service\MateriaService','id','nm_materia')->required(false)->label("Materia");
        $objForm->combo("id_assunto_materia", '\AssuntoMateria\Service\AssuntoMateriaService','id','nm_assunto_materia')->required(true)->label("Assunto");
        $objForm->text("nm_titulo_questao")->required(false)->label("Titulo da Questao");
        $objForm->textareaHtml("tx_enunciado")->required(false)->label("Enunciado da Questao");
        $objForm->text("tx_caminho_imagem_questao")->required(false)->label("Caminho da Imagem");


        $objForm->hidden("id_alternativa_questao_1")->required(false)->label("1 - Id Alternativa Questao");
        $objForm->textareaHtml("tx_alternativa_questao_1")->required(false)->label("1 - Enunciado da Alternativa");
        $objForm->select("cs_correta_1", array('E'=>'Errada', 'C' => 'Correta'))->required(false)->label("1 - Resposta");
        $objForm->textareaHtml("tx_justificativa_1")->required(false)->label("1 - Justificativa da Alternativa");
        $objForm->text("tx_caminho_imagem_alternativa_1")->required(false)->label("1 - Caminho da Imagem");

        $objForm->hidden("id_alternativa_questao_2")->required(false)->label("2 - Id Alternativa Questao");
        $objForm->textareaHtml("tx_alternativa_questao_2")->required(false)->label("2 - Enunciado da Alternativa");
        $objForm->select("cs_correta_2", array('E'=>'Errada', 'C' => 'Correta'))->required(false)->label("2 - Resposta");
        $objForm->textareaHtml("tx_justificativa_2")->required(false)->label("2 - Justificativa da Alternativa");
        $objForm->text("tx_caminho_imagem_alternativa_2")->required(false)->label("2 - Caminho da Imagem");

        $objForm->hidden("id_alternativa_questao_3")->required(false)->label("3 - Id Alternativa Questao");
        $objForm->textareaHtml("tx_alternativa_questao_3")->required(false)->label("3 - Enunciado da Alternativa");
        $objForm->select("cs_correta_3", array('E'=>'Errada', 'C' => 'Correta'))->required(false)->label("3 - Resposta");
        $objForm->textareaHtml("tx_justificativa_3")->required(false)->label("3 - Justificativa da Alternativa");
        $objForm->text("tx_caminho_imagem_alternativa_3")->required(false)->label("3 - Caminho da Imagem");

        $objForm->hidden("id_alternativa_questao_4")->required(false)->label("4 - Id Alternativa Questao");
        $objForm->textareaHtml("tx_alternativa_questao_4")->required(false)->label("4 - Enunciado da Alternativa");
        $objForm->select("cs_correta_4", array('E'=>'Errada', 'C' => 'Correta'))->required(false)->label("4 - Resposta");
        $objForm->textareaHtml("tx_justificativa_4")->required(false)->label("4 - Justificativa da Alternativa");
        $objForm->text("tx_caminho_imagem_alternativa_4")->required(false)->label("4 - Caminho da Imagem");

        $objForm->hidden("id_alternativa_questao_5")->required(false)->label("5 - Id Alternativa Questao");
        $objForm->textareaHtml("tx_alternativa_questao_5")->required(false)->label("5 - Enunciado da Alternativa");
        $objForm->select("cs_correta_5", array('E'=>'Errada', 'C' => 'Correta'))->required(false)->label("5 - Resposta");
        $objForm->textareaHtml("tx_justificativa_5")->required(false)->label("5 - Justificativa da Alternativa");
        $objForm->text("tx_caminho_imagem_alternativa_5")->required(false)->label("5 - Caminho da Imagem");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}