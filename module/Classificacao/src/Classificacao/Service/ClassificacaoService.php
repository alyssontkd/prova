<?php

namespace Classificacao\Service;

use \Classificacao\Entity\ClassificacaoEntity as Entity;
use Classificacao\Table\ClassificacaoTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ClassificacaoService extends Entity
{

    public function getClassificacaoToArray($id)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('classificacao_semestre')
            ->where([
                'classificacao_semestre.id_classificacao_semestre = ?' => $id,
                'classificacao_semestre.cs_ativo = 1',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarClassificacaoPorNomeToArray($nm_classificacao_semestre)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('classificacao_semestre')
            ->columns(array('nm_classificacao_semestre', 'id_cidade'))#Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "classificacao_semestre.nm_classificacao_semestre LIKE ?" => '%' . $nm_classificacao_semestre . '%',
                'classificacao_semestre.cs_ativo = 1',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getIdClassificacaoPorNomeToArray($nm_classificacao_semestre)
    {

        $arNomeClassificacao = explode('(', $nm_classificacao_semestre);
        $nm_classificacao_semestre = $arNomeClassificacao[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('classificacao_semestre')
            ->columns(array('id_classificacao_semestre'))
            ->where([
                'classificacao_semestre.nm_classificacao_semestre = ?' => $filter->filter($nm_classificacao_semestre),
                'classificacao_semestre.cs_ativo = 1',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    /**
     * Busca apenas os semestre que já estão relacionados a alguma questão
     *
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function filtrarSemestrePorBancoQuestao() {
        $select = new \Zend\Db\Sql\Select('classificacao_semestre');
        $select->columns([
            'id_classificacao_semestre',
            'nm_classificacao_semestre'
        ])->join('questao', 'questao.id_classificacao_semestre = classificacao_semestre.id_classificacao_semestre');

        $select->order(['questao.id_classificacao_semestre ASC']);

        return $this->getTable()->getTableGateway()->selectWith($select);
    }

    /**
     * Localizar itens por paginação
     *
     * @param type $pagina
     * @param type $itensPagina
     * @param type $ordem
     * @param type $like
     * @param type $itensPaginacao
     * @return type Paginator
     */
    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_classificacao_semestre ASC', $like = null, $itensPaginacao = 5)
    {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('classificacao_semestre')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_classificacao_semestre', "%{$like}%")
                ->or
                ->like('nm_classificacao_semestre', "%{$like}%")
                #->or
                #->like('telefone_principal', "%{$like}%")
                #->or
                #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \Classificacao\Entity\ClassificacaoEntity());

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
        // resultado da paginação
        return (new Paginator($paginatorAdapter))
            // pagina a ser buscada
            ->setCurrentPageNumber((int)$pagina)
            // quantidade de itens na p�gina
            ->setItemCountPerPage((int)$itensPagina)
            ->setPageRange((int)$itensPaginacao);
    }

    public function getClassificacaoPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('classificacao_semestre')->columns([
            'id_classificacao_semestre',
            'nm_classificacao_semestre'


        ]);
        /*->join('cidade', 'cidade.id_cidade = academias.id_cidade', [
            'nm_cidade'
        ])
        ->join('estado', 'estado.id_estado = cidade.id_estado', [
            'sg_estado'
        ]); */


        $where = [ 'classificacao_semestre.cs_ativo = 1',

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

        $select->where($where)->order(['id_classificacao_semestre DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function filtraClassificacaoAtivo()
    {
        $classificacaoAtivo = $this->select(['cs_ativo'=> '1']);
        return $classificacaoAtivo;
    }

}
