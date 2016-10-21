<?php

namespace Prova\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class VariasQuestoesAleatoriasForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('variasquestaoprovaaleatoriaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('questaoprovaaleatoriaform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->hidden("id_usuario")->required(false)->label("Id Usuario");

        $objForm->combo("id_tipo_questao", '\TipoQuestao\Service\TipoQuestaoService','id','nm_tipo_questao')->required(true)->label("Tipo");
        $objForm->combo("id_fonte_questao", '\Fonte\Service\FonteService','id','nm_fonte_questao')->required(true)->label("Selecionar a fonte");
        $objForm->combo("id_materia", '\Materia\Service\MateriaService','id','nm_materia')->required(true)->label("Materia");
        $objForm->combo("id_assunto_materia", '\AssuntoMateria\Service\AssuntoMateriaService','id','nm_assunto_materia')->required(true)->label("Assunto");
        $objForm->combo("id_nivel_dificuldade", '\NivelDificuldade\Service\NivelDificuldadeService','id','nm_nivel_dificuldade')->required(true)->label("Nivel de Dificuldade");
        $objForm->combo("id_classificacao_semestre", '\Classificacao\Service\ClassificacaoService','id','nm_classificacao_semestre')->required(true)->label("Classificaçao do semestre");
        $objForm->integer("nr_questoes")->required(true)->label("Quantidade de Questoes");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}