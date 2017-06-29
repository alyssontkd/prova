<?php

namespace Classificacao\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\JsonModel;
use Estrutura\Helpers\Cript;
use Zend\View\Model\ViewModel;

class ClassificacaoController extends AbstractCrudController
{
    /**
     * @var \Prova\Service\Prova
     */
    protected $service;

    /**
     * @var \Prova\Form\Prova
     */
    protected $form;

    public function __construct()
    {
        parent::init();
    }

    public function indexAction()
    {
        //return parent::index($this->service, $this->form);
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

            '2' => NULL,

        ];


        $paginator = $this->service->getClassificacaoPaginator($filter, $camposFilter);

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

    public function gravarAction()
    {
        #Alysson
        $controller = $this->params('controller');
        $this->addSuccessMessage('Registro gravado com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
        return parent::gravar($this->service, $this->form);
    }

    public function cadastroAction()
    {
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    public function obterClassificacaoAction()
    {

        $params = $this->getRequest()->getPost()->toArray();

        $form = new \Classificacao\Form\ClassificacaoForm(['params' => $params]);

        $dadosView = [
            'form' => $form,
            'controller' => $this->params('controller'),
        ];

        $view = new ViewModel($dadosView);
        return $view->setTerminal(true);
    }

    public function excluirLogAction(){

        $auth = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        $controller = $this->params('controller');
        $id_classificacao_semestre = $this->params('id');

        if (isset($id_classificacao_semestre) && $id_classificacao_semestre) {
            $id_classificacao_semestre = \Estrutura\Helpers\Cript::dec($id_classificacao_semestre);
        } else {
            $this->addErrorMessage('ID não informado');
            return $this->redirect()->toRoute('navegacao', ['controller' => $controller, 'action' => 'index']);
        }
        $classificacaoSemestreService = new \Classificacao\Service\ClassificacaoService();
        $mclassificacaoSemestreEntity = $classificacaoSemestreService->buscar($id_classificacao_semestre);

        if (1 == $auth->id_perfil) { //Se o usuario logado for Administrador
            $mclassificacaoSemestreEntity->setCsAtivo(0); // Valor '0' desabilita o campo cs_ativo
            $mclassificacaoSemestreEntity->salvar();
        }
        $this->addSuccessMessage('Classificação excluida com sucesso.');
        return $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
    }

}

