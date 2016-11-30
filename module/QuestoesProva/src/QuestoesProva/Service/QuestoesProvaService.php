<?php

namespace QuestoesProva\Service;

use \QuestoesProva\Entity\QuestoesProvaEntity as Entity;
use Zend\Db\Sql\Where;

class QuestoesProvaService extends Entity {

    public function retornaQuestoesExistentes($arIdQuestoes, $id_prova) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('questoes_prova')
                ->columns(['id_questao']) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
                ->where([
            'questoes_prova.id_prova = ?' => $id_prova,
        ]);

        $where = new Where();
        $where->in('questoes_prova.id_questao', $arIdQuestoes);
        $where->addPredicate(new \Zend\Db\Sql\Predicate\Expression('questoes_prova.id_prova = ?', $id_prova));
        $select->where($where);
        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getDetalharQuestoesPaginator($post) {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $subselect = $sql->select()
                ->from('questoes_prova')
                ->columns(array('id_questao'))
                ->where(array('questoes_prova.id_prova = ?' => $post['id']));

        $where = new Where();
        $where->notIn('questao.id_questao', $subselect);

        $select = $sql->select()
                ->from('questao')
                ->columns(array('id_questao', 'tx_enunciado', 'nm_titulo_questao'))
                ->join('assunto_materia', 'assunto_materia.id_assunto_materia = questao.id_assunto_materia')
                ->where($where);

        if (isset($post['id_classificacao_semestre']) && $post['id_classificacao_semestre']) {
            $select->where(array('questao.id_classificacao_semestre = ?' => $post['id_classificacao_semestre']));
        }
        if (isset($post['id_fonte_questao']) && $post['id_fonte_questao']) {
            $select->where(array('questao.id_fonte_questao = ?' => $post['id_fonte_questao']));
        }
        if (isset($post['id_materia']) && $post['id_materia']) {
            $select->where(array('assunto_materia.id_materia = ?' => $post['id_materia']));
        }
        if (isset($post['id_assunto_materia']) && $post['id_assunto_materia']) {
            $select->where(array('questao.id_assunto_materia = ?' => $post['id_assunto_materia']));
        }
        if (isset($post['id_nivel_dificuldade']) && $post['id_nivel_dificuldade']) {
            $select->where(array('questao.id_nivel_dificuldade = ?' => $post['id_nivel_dificuldade']));
        }
        if (isset($post['id_tipo_questao']) && $post['id_tipo_questao']) {
            $select->where(array('questao.id_tipo_questao = ?' => $post['id_tipo_questao']));
        }

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}
