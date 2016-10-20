<?php

namespace Questao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class QuestaoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('cadastroquestaoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('cadastroquestaoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_fonte_questao", '\Fonte\Service\FonteService','id','nm_fonte_questao')->required(true)->label("Selecionar a fonte");
        $objForm->combo("id_classificacao_semestre", '\Classificacao\Service\ClassificacaoService','id','nm_classificacao_semestre')->required(true)->label("Classificaçao do semestre");
        $objForm->combo("id_nivel_dificuldade", '\NivelDificuldade\Service\NivelDificuldadeService','id','nm_nivel_dificuldade')->required(true)->label("Nivel de Dificuldade");
        $objForm->combo("id_temporizacao", '\Temporizacao\Service\TemporizacaoService','id','nm_temporizacao')->required(true)->label("Temporizador");
        $objForm->combo("id_tipo_questao", '\TipoQuestao\Service\TipoQuestaoService','id','nm_tipo_questao')->required(true)->label("Tipo");
        $objForm->combo("id_materia", '\Materia\Service\MateriaService','id','nm_materia')->required(false)->label("Materia");
        $objForm->combo("id_assunto_materia", '\AssuntoMateria\Service\AssuntoMateriaService','id','nm_assunto_materia')->required(true)->label("Assunto");
        $objForm->text("nm_titulo_questao")->required(false)->label("Titulo da Questão");
        $objForm->textareaHtml("tx_enunciado")->required(false)->label("Enunciado da Questão");
        $objForm->text("tx_caminho_imagem_questao")->required(false)->label("Caminho da Imagem");

        #$objForm->combo("id_usuario_cadastro", '\Usuario\Service\UsuarioService', 'id', 'nm_usuario')->required(false)->label("Usuário");
        #$objForm->combo("id_usuario_alteracao", '\Usuario\Service\UsuarioService', 'id', 'nm_usuario')->required(false)->label("Usuário");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }}
