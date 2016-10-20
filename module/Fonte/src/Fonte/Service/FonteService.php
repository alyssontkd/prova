<?php

namespace Fonte\Service;

use \Fonte\Entity\FonteEntity as Entity;
use Fonte\Table\FonteTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class FonteService extends Entity {

    public function getFonteToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('fonte_questao')
            ->where([
                'fonte_questao.id_fonte_questao = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarFontePorNomeToArray($nm_fonte_questao) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('fonte_questao')
            ->columns(array('nm_fonte_questao', 'id_cidade') ) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "fonte_questao.nm_fonte_questao LIKE ?" => '%'.$nm_fonte_questao.'%',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getIdFontePorNomeToArray($nm_fonte_questao) {

        $arNomeFonte = explode('(', $nm_fonte_questao);
        $nm_fonte_questao = $arNomeFonte[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('fonte_questao')
            ->columns(array('id_fonte_questao') )
            ->where([
                'fonte_questao.nm_fonte_questao = ?' => $filter->filter($nm_fonte_questao),
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
    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_fonte_questao ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('fonte_questao')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_fonte_questao', "%{$like}%")
                    ->or
                    ->like('nm_fonte_questao', "%{$like}%")
            #->or
            #->like('telefone_principal', "%{$like}%")
            #->or
            #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \Fonte\Entity\FonteEntity());

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
    public function getFontePaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('fonte_questao')->columns([
                    'id_fonte_questao',
                    'nm_fonte_questao'
                    
                    
                ]);
                /*->join('cidade', 'cidade.id_cidade = academias.id_cidade', [
                    'nm_cidade'
                ])
                ->join('estado', 'estado.id_estado = cidade.id_estado', [
                    'sg_estado'
                ]); */              
               

        $where = [
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

        $select->where($where)->order(['nm_fonte_questao DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }




}
