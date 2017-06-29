<?php

namespace Prova\Entity;

use Estrutura\Service\AbstractEstruturaService;

class ProvaEntity extends AbstractEstruturaService{

		protected $id;
        protected $ds_prova; 
        protected $dt_aplicacao_prova;
        protected $dt_geracao_prova;
        protected $id_prova;
        protected $id_usuario;
        protected $nm_prova;
        protected $cs_ativo;
}