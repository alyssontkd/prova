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

    public function gravarQuestaoProvaAleatoria($questao, $dados) {
        $connection = $this->tableGateway->getAdapter()->getDriver()->getConnection();

        try {
            $connection->beginTransaction();

            $quantidade = $dados['nr_questoes'];
            $quantidade_questao = count($questao) - 1;

            $i = 1;
            while ($quantidade >= $i) {
                $random = rand(0, $quantidade_questao);
                if (array_key_exists($random, $questao)) {
                    parent::inserir(array(
                        'id_prova' => $dados['id'],
                        'id_questao' => $questao[$random]['id_questao']
                    ));
                    unset($questao[$random]);
                    $i++;
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
