<?php

namespace FiltroProva\Entity;

use Estrutura\Service\AbstractEstruturaService;

class FiltroProvaEntity extends AbstractEstruturaService{

    protected $id;
    protected $id_prova;
    protected $id_tipo_questao;
    protected $id_fonte_questao;
    protected $id_assunto_materia;
    protected $id_nivel_dificuldade;
    protected $id_classificacao_semestre;
    protected $nr_questoes;
    protected $cs_ativo;

}