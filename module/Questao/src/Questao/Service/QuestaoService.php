<?php

namespace Questao\Service;

use \Questao\Entity\QuestaoEntity as Entity;

use Questao\Table\Questao;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class QuestaoService extends Entity{

    public function getQuestaoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('questao')
            ->where([
                'questao.id_questao = ?' => $id,
                'questao.cs_ativo = 1',
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarQuestaoPorNomeToArray($tx_enunciado) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('questao')
            ->columns(array('tx_enunciado',) ) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "questao.id_questao LIKE ?" => '%'.$tx_enunciado.'%',
                'questao.cs_ativo = 1',
            ]);

        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getIdQuestaoPorNomeToArray($tx_enunciado) {

        $arNomeDaQuestao = explode('(', $tx_enunciado);
        $tx_enunciado = $arNomeDaQuestao[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('questao')
            ->columns(array('id_questao') )
            ->where([
                'questao.tx_enunciado = ?' => $filter->filter($tx_enunciado),
                'questao.cs_ativo = 1',
            ]);

        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'tx_enunciado DESC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('questao')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('tx_enunciado', "%{$like}%")
//                ->or
//                ->like('id_cidade', "%{$like}%")
                #->or
                #->like('telefone_principal', "%{$like}%")
                #->or
                #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \Questao\Entity\CadatroQuestao());

        // criar um objeto adapter paginator
        $paginatorAdapter = new DbSelect(
        // nosso objeto select
            $select,
            // nosso adapter da tabela
            $this->getAdapter(),
            // nosso objeto base para ser populado
            $resultSet
        );

        # var_dump($paginatorAdapter);
        #die;
        // resultado da paginaçao
        return (new Paginator($paginatorAdapter))
            // pagina a ser buscada
            ->setCurrentPageNumber((int) $pagina)
            // quantidade de itens na p�gina
            ->setItemCountPerPage((int) $itensPagina)
            ->setPageRange((int) $itensPaginacao);
    }

    public function getQuestaoPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('questao')->columns([
            'id_questao',
            'nm_titulo_questao',
            'tx_enunciado',
            'tx_caminho_imagem_questao'
        ])
            ->join('nivel_dificuldade', 'nivel_dificuldade.id_nivel_dificuldade = questao.id_nivel_dificuldade', [
                'nm_nivel_dificuldade'
            ])

            ->join('assunto_materia', 'assunto_materia.id_assunto_materia = questao.id_assunto_materia', [
                'nm_assunto_materia',
            ])

            ->join('materia', 'materia.id_materia = assunto_materia.id_materia', [
                'nm_materia'
           ])

            ->join('temporizacao', 'temporizacao.id_temporizacao = questao.id_temporizacao', [
                'nm_temporizacao',
            ])
//            ->join('tipo_questao', 'tipo_questao.id_tipo_questao = questao.id_tipo_questao', [
//                'nm_tipo_questao',
//           ])
         ;


        $where = ['questao.cs_ativo = 1',
        ];

        if (!empty($filter)) {

            foreach ($filter as $key => $value) {

                if ($value) {

                    if (isset($camposFilter[$key]['mascara'])) {

                        eval("\$value = " . $camposFilter[$key]['mascara'] . ";");
                    }

                    $where[$camposFilter[$key]['filter']] = '%' . $value . '%';
                }
            }
        }

        $select->where($where)->order(['id_questao DESC']);

        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }



}