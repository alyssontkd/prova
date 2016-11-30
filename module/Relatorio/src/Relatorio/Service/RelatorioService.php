<?php

namespace Relatorio\Service;

use Estrutura\Service\AbstractEstruturaService;
use Zend\Db\Sql\Expression;
use Estrutura\Service\AbstractEstruturaService;

class RelatorioService extends AbstractEstruturaService {

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

    public function getUsuariosPerfis() {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select()
            ->from(array('usuario' => 'usuario'))
            ->join('usuario', 'usuario.id_perfil = pefil.id_usuario')
            ->columns(array('nm_usaurio', 'perfil' => new Expression('COUNT(*)')))
            ->group(array('nm_usuario', 'nm_perfil'));

        return $sql->prepareStatementForSqlObject($select)->execute();
    }


    public function getMateriasSemestre() {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select()
                ->from(array('materia' => 'materia'))
                ->join('materia_semestre', 'materia_semestre.id_materia = materia.id_materia')
                ->join('classificacao_semestre', 'classificacao_semestre.id_classificacao_semestre = materia_semestre.id_classificacao_semestre')
                ->columns(array('nm_materia'))
                
                ->group(array('nm_classificacao_semestre', 'nm_materia'));
        return $sql->prepareStatementForSqlObject($select)->execute();
    }

}
