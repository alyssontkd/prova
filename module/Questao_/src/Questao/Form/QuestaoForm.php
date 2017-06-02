<?php

namespace Questao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class QuestaoForm extends AbstractForm
{
    public function __construct($options = [])
    {
        parent::__construct('cadastroquestaoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('cadastroquestaoform', $this, $this->inputFilter);

        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_fonte_questao", '\Fonte\Service\FonteService', 'id', 'nm_fonte_questao')->required(true)->label("Selecionar a fonte");
        $objForm->combo("id_classificacao_semestre", '\Classificacao\Service\ClassificacaoService', 'id', 'nm_classificacao_semestre')->required(true)->label("Classificação do semestre");
        $objForm->combo("id_nivel_dificuldade", '\NivelDificuldade\Service\NivelDificuldadeService', 'id', 'nm_nivel_dificuldade')->required(true)->label("Nível de Dificuldade");

        #$objForm->combo("id_temporizacao", '\Temporizacao\Service\TemporizacaoService', 'id', 'nm_temporizacao')->required(false)->label("Temporizador");
        $objForm->hidden("id_temporizacao")->required(false)->label("Id");
        #$objForm->combo("id_tipo_questao", '\TipoQuestao\Service\TipoQuestaoService', 'id', 'nm_tipo_questao')->required(false)->label("Tipo");
        $objForm->hidden("id_tipo_questao")->required(false)->label("Id");

        $objForm->select("id_materia", array('' => 'Selecione um Semestre...'))->required(false)->label("Matéria");
        $objForm->select("id_assunto_materia", array('' => 'Selecione uma Matéria...'))->required(false)->label("Assunto");

        $objForm->text("nm_titulo_questao")->required(true)->label("Título da Questão");
        $objForm->textareaHtml("tx_enunciado")->required(false)->label("Enunciado da Questão");
        $objForm->text("tx_caminho_imagem_questao")->required(false)->label("Caminho da Imagem");

        $objForm->hidden("id_usuario_cadastro")->required(false)->label("id_usuario_cadastro");
        $objForm->hidden("id_usuario_alteracao")->required(false)->label("id_usuario_alteracao");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}
