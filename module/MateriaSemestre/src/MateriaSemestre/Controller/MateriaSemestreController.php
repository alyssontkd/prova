<?php

namespace MateriaSemestre\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Estrutura\Helpers\Cript;


class MateriaSemestreController extends AbstractCrudController
{
    /**
     * @var \Action\Service\Action
     */
    protected $service;

    /**
     * @var \Action\Form\Action
     */
    protected $form;

    public function __construct(){
        parent::init();
    }

    public function indexAction()
    {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/

        return new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'controller' => $this->params('controller'),
            'atributos' => array()
        ]);
    }

    public function indexPaginationAction()
    {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/

        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => [
                'filter' => "classificacao_semestre.nm_classificacao_semestre LIKE ?",
            ],
            '1' => [
                'filter' => "materia.nm_materia LIKE ?",
            ],
            '2' => NULL,
        ];


        $paginator = $this->service->getMateriaSemestrePaginator($filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }

    public function gravarAction(){
        $controller = $this->params('controller');
        $this->addSuccessMessage('Registro Alterado com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
        return parent::gravar($this->service, $this->form);
    }

    public function cadastroAction()
    {
        //Se for chamado via formulario de alteração
        if ($this->params('id_classificacao_semestre') ) {
            $id_classificacao_semestre = Cript::dec($this->params('id_classificacao_semestre'));

            $arAtributos = array(
                'id_classificacao_semestre' => $id_classificacao_semestre,
            );
            $this->form->setData($arAtributos);

            #xd($id_classificacao_semestre);
            $dadosView = [
                'service' => $this->service,
                'form' => $this->form,
                'controller' => $this->params('controller'),
                'atributos' => array(),
                'id_classificacao_semestre' => $id_classificacao_semestre,
            ];
            return new ViewModel($dadosView);

        } else { #Se for chamado via botao de cadastro
            return parent::cadastro($this->service, $this->form);
        }

    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    public function detalhePaginationAction()
    {
        $filter = $this->getFilterPage();

        $id_classificacao_semestre = $this->params()->fromPost('id_classificacao_semestre');

        $camposFilter = [
            '0' => [
                //'filter' => "periodoletivodetalhe.nm_sacramento LIKE ?",
            ],
            '1' => [
                //'filter' => "periodoletivodetalhe.nm_sacramento LIKE ?",
            ],
            '2' => [
                //'filter' => "periodoletivodetalhe.nm_sacramento LIKE ?",
            ],
            '3' =>NULL,

        ];

        #xd($this->params());
        $paginator = $this->service->getMateriaSemestreInternoPaginator($id_classificacao_semestre, $filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => new \MateriaSemestre\Form\MateriaSemestreForm(),
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'id_classificacao_semestre' => $id_classificacao_semestre,
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }

    public function relacionarMateriaAction()
    {
        //Se for a chamada Ajax
        if ($this->getRequest()->isPost()) {
            $id_classificacao_semestre = $this->params()->fromPost('id_classificacao_semestre');
            $id_materia = $this->params()->fromPost('id_materia');

            $obj_turma_catequisando = new \MateriaSemestre\Service\MateriaSemestreService();


            $arDadosGravar = array(
                'id_classificacao_semestre' => $id_classificacao_semestre,
                'id_materia' => $id_materia,
            );
            $id_inserido = $obj_turma_catequisando->getTable()->salvar($arDadosGravar, null);
            $valuesJson = new JsonModel(array('id_inserido' => $id_inserido, 'sucesso' => true, 'id_classificacao_semestre' => $id_classificacao_semestre, 'id_materia' => $id_materia));

            return $valuesJson;
        }
    }

    public function excluirRelacaoMateriaSemestreAction()
    {
        try {
            $request = $this->getRequest();

            if ($request->isPost()) {
                return new JsonModel();
            }

            $controller = $this->params('controller');

            $id_materia_semestre = Cript::dec($this->params('id_materia_semestre'));
            $id_classificacao_semestre = Cript::dec($this->params('id_classificacao_semestre'));

            $this->service->setId($id_materia_semestre);

            $dados = $this->service->filtrarObjeto()->current();

            if (!$dados) {
                throw new \Exception('Registro não encontrado');
            }

            $this->service->excluir();
            $this->addSuccessMessage('Registro excluido com sucesso');
            return $this->redirect()->toRoute('alterar_materia_semestre', array('controller' => 'materia_semestre-materiasemestre', 'action' => 'cadastro', 'id_classificacao_semestre' => Cript::enc($id_classificacao_semestre) ));
        } catch (\Exception $e) {
            if (strstr($e->getMessage(), '1451')) { #ERRO de SQL (Mysql) para nao excluir registro que possua filhos
                $this->addErrorMessage('Para excluir este registro, apague todos os filhos deste registro primeiro!');
            } else {
                $this->addErrorMessage($e->getMessage());
            }

            return $this->redirect()->toRoute('navegacao', ['controller' => $controller]);
        }

        return parent::excluir($this->service, $this->form);
    }

    public function excluirLogAction(){

        $auth = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        $controller = $this->params('controller');
        $id_materiaSemestre = $this->params('id');

        if (isset($id_materiaSemestre) && $id_materiaSemestre) {
            $id_materiaSemestre = \Estrutura\Helpers\Cript::dec($id_materiaSemestre);
        } else {
            $this->addErrorMessage('ID não informado');
            return $this->redirect()->toRoute('navegacao', ['controller' => $controller, 'action' => 'index']);
        }
        $materiaSemestreService = new \Materia\Service\MateriaService();
        $materiaSemestreEntity = $materiaSemestreService->buscar($id_materiaSemestre);

        if (1 == $auth->id_perfil) { //Se o usuario logado for Administrador
            $materiaSemestreEntity->setCsAtivo(0); // Valor '0' desabilita o campo cs_ativo
            $materiaSemestreEntity->salvar();
        }
        $this->addSuccessMessage('Matéria excluida com sucesso.');
        return $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
    }
}
