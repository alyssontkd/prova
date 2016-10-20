<?php

namespace QuestoesProva\Service;

use \QuestoesProva\Entity\QuestoesProvaEntity as Entity;
use Zend\Db\Sql\Where;

class QuestoesProvaService extends Entity{

    public function retornaQuestoesExistentes($arIdQuestoes, $id_prova) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('questoes_prova')
            ->columns(['id_questao']) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                'questoes_prova.id_prova = ?' => $id_prova,
            ]);

        $where = new Where();
        $where->in('questoes_prova.id_questao', $arIdQuestoes);
        $where->addPredicate(new \Zend\Db\Sql\Predicate\Expression('questoes_prova.id_prova = ?', $id_prova ));
        $select->where($where);
        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
        return $sql->prepareStatementForSqlObject($select)->execute();
    }

}