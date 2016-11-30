<?php

namespace QuestoesProva\Table;

use Estrutura\Table\AbstractEstruturaTable;

class QuestoesProvaTable extends AbstractEstruturaTable {

    public $table = 'questoes_prova';
    public $campos = [
        'id_questao_prova' => 'id',
        'id_questao' => 'id_questao',
        'id_prova' => 'id_prova',
    ];

    public function gravarQuestaoProvaManual($dados) {

        $connection = $this->tableGateway->getAdapter()->getDriver()->getConnection();

        try {
            $connection->beginTransaction();

            $id_prova = $dados['id_prova'];
            unset($dados['id_prova']);

            foreach ($dados as $id_questao => $checked) {
                if ($checked) {
                    parent::inserir(array(
                        'id_prova' => $id_prova,
                        'id_questao' => $id_questao
                    ));
                }
            }

            $connection->commit();

            return true;
        } catch (\Zend\Db\Adapter\Exception\InvalidQueryException $ex) {
            $connection->rollback();

            return $ex;
        }
    }

}
