<?php

namespace Materia\Service;

use \Materia\Entity\MateriaEntity as Entity;
use Materia\Table\MateriaTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class MateriaService extends Entity {

    public function getTiposToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('materia')
            ->where([
                'materia.id_materia = ?' => $id,
                'materia.cs_ativo = 1',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarTiposPorNomeToArray($nm_materia) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('materia')
            ->columns(array('nm_materia',) ) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "materia.id_materia LIKE ?" => '%'.$nm_materia.'%',
                'materia.cs_ativo = 1',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getIdTipoPorNomeToArray($nm_materia) {

        $arNomeMateria = explode('(', $nm_materia);
        $nm_materia = $arNomeMateria[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('materia')
            ->columns(array('id_materia') )
            ->where([
                'materia.nm_materia = ?' => $filter->filter($nm_materia),
                'materia.cs_ativo = 1',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_materia DESC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('materia')->order($ordem);

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
        $resultSet = new HydratingResultSet(new Reflection(), new \Materia\Entity\Materia());

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
        // resultado da paginacao
        return (new Paginator($paginatorAdapter))
            // pagina a ser buscada
            ->setCurrentPageNumber((int) $pagina)
            // quantidade de itens na pagina
            ->setItemCountPerPage((int) $itensPagina)
            ->setPageRange((int) $itensPaginacao);
    }

    public function getMateriaPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('materia')->columns([
            'id_materia',
            'nm_materia',
            'cs_ativo',
        ]);

        $where = [
            'materia.cs_ativo = 1',// Condição para filtro da exclusão lógica '0'ativo e '1'inativo
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

        $select->where($where)->order(['id_materia DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function carregarMateriaPorSemestre($id_classificacao_semestre)
    {
        $select = new \Zend\Db\Sql\Select('materia');
        $select->columns([
            'id_materia',
            'nm_materia'
        ])->join('assunto_materia', 'assunto_materia.id_materia = materia.id_materia')
            ->join('questao', 'questao.id_assunto_materia = assunto_materia.id_assunto_materia');

        $select->where([
            'questao.id_classificacao_semestre = ?' => $id_classificacao_semestre,
            'materia.cs_ativo = 1',
        ]);
        $select->order(['materia.nm_materia ASC']);
        $select->quantifier('DISTINCT');
        return $this->getTable()->getTableGateway()->selectWith($select);
    }

    public function filtraMateriaAtiva()
    {
        $materiaAtiva = $this->select(['cs_ativo'=> '1']);
        return $materiaAtiva;
    }
}
