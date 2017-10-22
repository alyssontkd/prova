<?php

namespace Questao\Entity;

use Estrutura\Service\AbstractEstruturaService;

class QuestaoEntity extends AbstractEstruturaService{

    protected $id;
    protected $id_usuario_cadastro;
    protected $id_usuario_alteracao;
    protected $id_classificacao_semestre;
    protected $id_nivel_dificuldade;
    protected $id_temporizacao;
    protected $id_tipo_questao;
    protected $id_fonte_questao;
    protected $id_assunto_materia;
    protected $nm_titulo_questao;
    protected $tx_enunciado;
    protected $tx_caminho_imagem_questao;
    protected $cs_ativo;

    protected $dt_cadastro;
    protected $dt_alteracao;
    protected $dt_ultima_utilizacao;
    protected $bo_utilizavel;




}