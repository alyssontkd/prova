<?php

namespace NivelDificuldade\Service;

use \NivelDificuldade\Entity\NivelDificuldadeEntity as Entity;
use NivelDificuldade\Table\NivelDificuldadeTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class NivelDificuldadeService extends Entity {

    public function getNivelDificuldadeToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('nivel_dificuldade')
            ->where([
                'nivel_dificuldade.id_nivel_dificuldade = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarNivelDificuldadePorNomeToArray($nm_nivel_dificuldade) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('nivel_dificuldade')
            ->columns(array('nm_nivel_dificuldade', 'id_cidade') ) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "nivel_dificuldade.nm_nivel_dificuldade LIKE ?" => '%'.$nm_nivel_dificuldade.'%',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getIdNivelDificuldadePorNomeToArray($nm_nivel_dificuldade) {

        $arNomeNivelDificuldade = explode('(', $nm_nivel_dificuldade);
        $nm_nivel_dificuldade = $arNomeNivelDificuldade[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('nivel_dificuldade')
            ->columns(array('id_nivel_dificuldade') )
            ->where([
                'nivel_dificuldade.nm_nivel_dificuldade = ?' => $filter->filter($nm_nivel_dificuldade),
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    /**
     * Busca apenas as Nivel de Dificuldade que já estão relacionados a alguma questão
     *
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function filtrarNivelDificuldadePorBancoQuestao() {
        $select = new \Zend\Db\Sql\Select('nivel_dificuldade');
        $select->columns([
            'id_nivel_dificuldade',
            'nm_nivel_dificuldade'
        ])->join('questao', 'questao.id_nivel_dificuldade = nivel_dificuldade.id_nivel_dificuldade');

        $select->order(['nivel_dificuldade.id_nivel_dificuldade ASC']);

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
    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_nivel_dificuldade ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('nivel_dificuldade')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_nivel_dificuldade', "%{$like}%")
                    ->or
                    ->like('nm_nivel_dificuldade', "%{$like}%")
            #->or
            #->like('telefone_principal', "%{$like}%")
            #->or
            #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \NivelDificuldade\Entity\NivelDificuldadeEntity());

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
    public function getNivelDificuldadePaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('nivel_dificuldade')->columns([
                    'id_nivel_dificuldade',
                    'nm_nivel_dificuldade'
                    
                    
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

        $select->where($where)->order(['nm_nivel_dificuldade DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }




}
