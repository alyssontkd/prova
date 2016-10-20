<?php

namespace AlternativaQuestao\Entity;

use Estrutura\Service\AbstractEstruturaService;

class AlternativaQuestaoEntity extends AbstractEstruturaService
{

    protected $id;
    protected $id_usuario_cadastro;
    protected $id_usuario_alteracao;
    protected $id_questao;
    protected $tx_alternativa_questao;
    protected $tx_caminho_imagem_alternativa;
    protected $cs_correta;
    protected $tx_justificativa;
    protected $dt_cadastro;
    protected $dt_alteracao;


}