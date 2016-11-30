<?php

namespace AlternativaQuestao\View\Helper;

use AlternativaQuestao\Service\AlternativaQuestaoService;
use Zend\View\Helper\AbstractHelper;

/**
 * Description of Alternativa
 *
 * @author José Matheus
 */
class ListarAlternativas extends AbstractHelper {

    protected $service = null;

    public function __construct(AlternativaQuestaoService $service) {
        $this->service = $service;
    }

    public function __invoke($id_questao) {
        return $this->service->getAlternativasQuestao($id_questao);
    }

}
