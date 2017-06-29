<?php

namespace TipoQuestao\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;


class TipoQuestaoController extends AbstractCrudController
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
                'filter' => "tipo_questao.nm_tipo_questao LIKE ?",
            ],
            '1' => NULL,
        ];


        $paginator = $this->service->getTipoQuestaoPaginator($filter, $camposFilter);

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
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    public function excluirLogAction(){

        $auth = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        $controller = $this->params('controller');
        $id_tipoQuestao = $this->params('id');

        if (isset($id_tipoQuestao) && $id_tipoQuestao) {
            $id_tipoQuestao = \Estrutura\Helpers\Cript::dec($id_tipoQuestao);
        } else {
            $this->addErrorMessage('ID não informado');
            return $this->redirect()->toRoute('navegacao', ['controller' => $controller, 'action' => 'index']);
        }
        $tipoQuestaoService = new \TipoQuestao\Service\TipoQuestaoService();
        $tipoQuestaoEntity = $tipoQuestaoService->buscar($id_tipoQuestao);

        if (1 == $auth->id_perfil) { //Se o usuario logado for Administrador
            $tipoQuestaoEntity->setCsAtivo(0); // Valor '0' desabilita o campo cs_ativo
            $tipoQuestaoEntity->salvar();
        }
        $this->addSuccessMessage('Tipo de Questão excluido com sucesso.');
        return $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
    }
}
