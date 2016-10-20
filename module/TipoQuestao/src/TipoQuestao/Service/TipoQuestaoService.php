<?php

namespace TipoQuestao\Service;

use \TipoQuestao\Entity\TipoQuestaoEntity as Entity;
use TipoQuestao\Table\TipoQuestaoTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class TipoQuestaoService extends Entity {



    public function getTiposToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('tipo_questao')
            ->where([
                'tipo_questao.id_tipo_questao = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarTiposPorNomeToArray($nm_tipo_questao) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('tipo_questao')
            ->columns(array('nm_tipo_questao',) ) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "tipo_questao.id_tipo_questao LIKE ?" => '%'.$nm_tipo_questao.'%',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getIdTipoPorNomeToArray($nm_tipo_questao) {

        $arNomeDoTipo = explode('(', $nm_tipo_questao);
        $nm_tipo_questao = $arNomeDoTipo[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('tipo_questao')
            ->columns(array('id_tipo_questao') )
            ->where([
                'tipo_questao.nm_tipo_questao = ?' => $filter->filter($nm_tipo_questao),
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_tipo_questao DESC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('tipo_questao')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('nm_tipo_questao', "%{$like}%")
//                ->or
//                ->like('id_cidade', "%{$like}%")
                #->or
                #->like('telefone_principal', "%{$like}%")
                #->or
                #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \TipoQuestao\Entity\TipoQuestao());

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

    public function getTipoQuestaoPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('tipo_questao')->columns([
            'id_tipo_questao',
            'nm_tipo_questao',




        ]);
//            ->join('estado', 'estado.id_estado = cidade.id_estado', [
//                'nm_estado'
//            ]);







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

        $select->where($where)->order(['nm_tipo_questao DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }


}
