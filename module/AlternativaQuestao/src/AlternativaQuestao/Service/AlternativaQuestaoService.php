<?php

namespace AlternativaQuestao\Service;

use \AlternativaQuestao\Entity\AlternativaQuestaoEntity as Entity;

class AlternativaQuestaoService extends Entity {

    public function getAlternativasQuestao($id_questao) {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select()
                ->from('alternativa_questao')
                ->where(array('alternativa_questao.id_questao = ?' => $id_questao));

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

}
