<?php

namespace Relatorio\Service;

use \AssuntoMateria\Entity\AssuntoMateriaEntity as Entity;
//use AssuntoMateria\Table\AssuntoMateriaTable;
//use Zend\Db\Sql\Select;
//use Zend\Db\ResultSet\HydratingResultSet;
//use Zend\Stdlib\Hydrator\Reflection;
//use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\Sql\Expression;

class RelatorioService extends Entity {

    public function getQuantitativoQuestoesPorAssunto() {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select()
                ->from(array('assunto_materia' => 'assunto_materia'))
                ->join('questao', 'questao.id_assunto_materia = assunto_materia.id_assunto_materia')
                ->join('fonte_questao', 'fonte_questao.id_fonte_questao = questao.id_fonte_questao', array('nm_fonte_questao'))
                ->columns(array('nm_assunto_materia', 'quantidade' => new Expression('COUNT(*)')))
                ->group(array('nm_fonte_questao', 'nm_assunto_materia'));

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

}
