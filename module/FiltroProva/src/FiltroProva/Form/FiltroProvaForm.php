<?php

namespace FiltroProva\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class FiltroProvaForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('filtroprovaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('filtroprovaform',$this,$this->inputFilter);

        $objForm->hidden("id")->required(false)->label("Id");

        $objForm->combo("id_prova", '\Prova\Service\ProvaService','id','nm_prova')->required(false)->label("Prova");
        $objForm->combo("id_tipo_questao", '\TipoQuestao\Service\TipoQuestaoService','id','nm_tipo_questao')->required(true)->label("Tipo");
        $objForm->combo("id_fonte_questao", '\Fonte\Service\FonteService','id','nm_fonte_questao')->required(false)->label("Selecionar a fonte");
        $objForm->combo("id_materia", '\Materia\Service\MateriaService','id','nm_materia')->required(false)->label("Matéria");
        $objForm->combo("id_assunto_materia", '\AssuntoMateria\Service\AssuntoMateriaService','id','nm_assunto_materia')->required(false)->label("Assunto");
        $objForm->combo("id_nivel_dificuldade", '\NivelDificuldade\Service\NivelDificuldadeService','id','nm_nivel_dificuldade')->required(false)->label("Nível de Dificuldade");
        $objForm->combo("id_classificacao_semestre", '\Classificacao\Service\ClassificacaoService','id','nm_classificacao_semestre')->required(false)->label("Classificação do semestre");
        $objForm->integer("nr_questoes")->required(false)->label("Quantidade de Questões");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}