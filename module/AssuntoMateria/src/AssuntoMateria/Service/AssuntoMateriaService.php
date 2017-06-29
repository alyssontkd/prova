<?php

namespace AssuntoMateria\Service;

use \AssuntoMateria\Entity\AssuntoMateriaEntity as Entity;
use AssuntoMateria\Table\AssuntoMateriaTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class AssuntoMateriaService extends Entity {



    public function getTiposToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('assunto_materia')
            ->where([
                'assunto_materia.id_assunto_materia = ?' => $id,
                'assunto_materia.cs_ativo = 1',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarTiposPorNomeToArray($nm_assunto_materia) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('assunto_materia')
            ->columns(array('nm_assunto_materia',) ) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "assunto_materia.id_assunto_materia LIKE ?" => '%'.$nm_assunto_materia.'%',
                'assunto_materia.cs_ativo = 1',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getIdTipoPorNomeToArray($nm_assunto_materia) {

        $arNomeAssunto = explode('(', $nm_assunto_materia);
        $nm_assunto_materia = $arNomeAssunto[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('assunto_materia')
            ->columns(array('id_assunto_materia') )
            ->where([
                'assunto_materia.id_assunto_materia = ?' => $filter->filter($nm_assunto_materia),
                'assunto_materia.cs_ativo = 1',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_assunto_materia DESC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('assunto_materia')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('nm_assunto_materia', "%{$like}%")
//                ->or
//                ->like('id_cidade', "%{$like}%")
                #->or
                #->like('telefone_principal', "%{$like}%")
                #->or
                #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \AssuntoMateria\Entity\AssuntoMateria());

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

    public function getAssuntoMateriaPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('assunto_materia')->columns([
            'id_assunto_materia',
            'nm_assunto_materia',

        ])
            ->join('materia', 'materia.id_materia = assunto_materia.id_materia', [
                'nm_materia'
            ])
            ->join('materia_semestre', 'materia_semestre.id_materia = materia.id_materia')
            ->join('classificacao_semestre', 'materia_semestre.id_classificacao_semestre = classificacao_semestre.id_classificacao_semestre', [
            'nm_classificacao_semestre'
        ]);


        $where = ['assunto_materia.cs_ativo = 1','materia.cs_ativo = 1',
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

        $select->where($where)->order(['id_assunto_materia DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function carregarAssuntoPorMateria($id_materia)
    {

        return $this->select(
            [
                'assunto_materia.id_materia = ?' => $id_materia,
            ]
        );
    }

    public function filtraAssuntoAtivo()
    {
        $assuntoAtivo = $this->select(['cs_ativo'=> '1']);
        return $assuntoAtivo;
    }
}
