<?php

namespace Temporizacao\Service;

use \Temporizacao\Entity\TemporizacaoEntity as Entity;
use Temporizacao\Table\TemporizacaoTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class TemporizacaoService extends Entity {

    public function getTemporizacaoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('temporizacao')
            ->where([
                'temporizacao.id_temporizacao = ?' => $id,
                'temporizacao.cs_ativo=1',
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarTemporizacaoPorNomeToArray($nm_temporizacao) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('temporizacao')
            ->columns(array('nm_temporizacao', 'id_cidade') ) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "temporizacao.nm_temporizacao LIKE ?" => '%'.$nm_temporizacao.'%',
                'temporizacao.cs_ativo=1',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getIdTemporizacaoPorNomeToArray($nm_temporizacao) {

        $arNomeTemporizacao = explode('(', $nm_temporizacao);
        $nm_temporizacao = $arNomeTemporizacao[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('temporizacao')
            ->columns(array('id_temporizacao') )
            ->where([
                'temporizacao.nm_temporizacao = ?' => $filter->filter($nm_temporizacao),
                'temporizacao.cs_ativo=1',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    /**
     * Localizar itens por pagina��o
     *
     * @param type $pagina
     * @param type $itensPagina
     * @param type $ordem
     * @param type $like
     * @param type $itensPaginacao
     * @return type Paginator
     */
    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_temporizacao ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('temporizacao')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_temporizacao', "%{$like}%")
                    ->or
                    ->like('nm_temporizacao', "%{$like}%")
            #->or
            #->like('telefone_principal', "%{$like}%")
            #->or
            #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \Temporizacao\Entity\TemporizacaoEntity());

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
        // resultado da pagina��o
        return (new Paginator($paginatorAdapter))
                        // pagina a ser buscada
                        ->setCurrentPageNumber((int) $pagina)
                        // quantidade de itens na p�gina
                        ->setItemCountPerPage((int) $itensPagina)
                        ->setPageRange((int) $itensPaginacao);
    }

    /**
     * 
     * @param type $dtInicio
     * @param type $dtFim
     * @return type
     */
    public function getTemporizacaoPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('temporizacao')->columns([
                    'id_temporizacao',
                    'nm_temporizacao'
                    
                    
                ]);
                /*->join('cidade', 'cidade.id_cidade = academias.id_cidade', [
                    'nm_cidade'
                ])
                ->join('estado', 'estado.id_estado = cidade.id_estado', [
                    'sg_estado'
                ]); */              
               

        $where = ['temporizacao.cs_ativo=1',
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

        $select->where($where)->order(['id_temporizacao DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function filtraTemporizacaoAtivo()
    {
        $temporizacaoAtivo = $this->select(['cs_ativo'=> '1']);
        return $temporizacaoAtivo;
    }


}
