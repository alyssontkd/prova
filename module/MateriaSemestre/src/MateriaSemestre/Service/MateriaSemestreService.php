<?php

namespace MateriaSemestre\Service;

use \MateriaSemestre\Entity\MateriaSemestreEntity as Entity;
use MateriaSemestre\Table\MateriaSemestreTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class MateriaSemestreService extends Entity {



    public function getTiposToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('assunto_materia')
            ->where([
                'assunto_materia.id_assunto_materia = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarTiposPorNomeToArray($nm_assunto_materia) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('assunto_materia')
            ->columns(array('nm_assunto_materia',) ) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "assunto_materia.id_assunto_materia LIKE ?" => '%'.$nm_assunto_materia.'%',
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
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_assunto_materia DESC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('classificacao_semestre')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_materia', "%{$like}%")
//                ->or
//                ->like('id_cidade', "%{$like}%")
                #->or
                #->like('telefone_principal', "%{$like}%")
                #->or
                #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \MateriaSemestre\Entity\MateriaSemestre());

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

    public function getMateriaSemestrePaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('materia_semestre')->columns([
            #'id_materia_semestre',
            'id_classificacao_semestre',
            #'id_materia',
        ])#->join('materia', 'materia.id_materia = materia_semestre.id_materia', [
          #      'nm_materia'
          #])
        ->join('classificacao_semestre', 'materia_semestre.id_classificacao_semestre = classificacao_semestre.id_classificacao_semestre', [
            'nm_classificacao_semestre'
        ]);

        $select->quantifier('DISTINCT');

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

        $select->where($where)->order(['nm_classificacao_semestre ASC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function getMateriaSemestreInternoPaginator($id_classificacao_semestre, $filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('materia_semestre')->columns([
            'id_materia_semestre',
            'id_classificacao_semestre',
            'id_materia',
        ])->join('materia', 'materia.id_materia = materia_semestre.id_materia', [
            'nm_materia'
        ])->join('classificacao_semestre', 'materia_semestre.id_classificacao_semestre = classificacao_semestre.id_classificacao_semestre', [
            'nm_classificacao_semestre'
        ]);

        $where = [
            'materia_semestre.id_classificacao_semestre'=>$id_classificacao_semestre,
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

        $select->where($where)->order(['nm_materia ASC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}
