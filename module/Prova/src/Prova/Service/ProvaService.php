<?php

namespace Prova\Service;

use \Prova\Entity\ProvaEntity as Entity;
use Prova\Table\ProvaTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ProvaService extends Entity {

    public function getProvaToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('prova')
            ->where([
                'prova.id_prova = ?' => $id,
                'prova.cs_ativo = 1',
            ]);
        #xd($select->getSqlString($this->getAdapter()->getPlatform()));

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarProvaPorNomeToArray($nm_prova) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('prova')
            ->columns(array('nm_prova', 'id_cidade') ) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "prova.nm_prova LIKE ?" => '%'.$nm_prova.'%',
                'prova.cs_ativo = 1',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getIdProvaPorNomeToArray($nm_prova) {

        $arNomeProva = explode('(', $nm_prova);
        $nm_prova = $arNomeProva[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('prova')
            ->columns(array('id_prova') )
            ->where([
                'prova.nm_prova = ?' => $filter->filter($nm_prova),
                'prova.cs_ativo = 1',
            ]);

        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_prova ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('prova')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_prova', "%{$like}%")
                    ->or
                    ->like('nm_prova', "%{$like}%")
            #->or
            #->like('telefone_principal', "%{$like}%")
            #->or
            #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \Prova\Entity\ProvaEntity());

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

    public function getProvasPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('prova')->columns([
                    'id_prova',
                    'nm_prova',
                    'dt_aplicacao_prova',
                    'dt_geracao_prova',
                    'ds_prova'
                    
                ]);
                /*->join('cidade', 'cidade.id_cidade = academias.id_cidade', [
                    'nm_cidade'
                ])
                ->join('estado', 'estado.id_estado = cidade.id_estado', [
                    'sg_estado'
                ]); */              
               

        $where = ['prova.cs_ativo = 1',
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

        $select->where($where)->order(['nm_prova DESC']);

        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function getDetalhesFiltrosPaginator($id_prova, $filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('filtro_prova')->columns([
            'id_filtro_prova',
            'id_prova',
            'id_tipo_questao',
            'id_fonte_questao',
            'id_assunto_materia',
            'id_nivel_dificuldade',
            'id_classificacao_semestre',
            'nr_questoes',
        ]);

        $where = [
            'id_prova'=>$id_prova,
            'prova.cs_ativo = 1',
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

        $select->where($where)->order(['id_prova DESC']);

        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }


}
