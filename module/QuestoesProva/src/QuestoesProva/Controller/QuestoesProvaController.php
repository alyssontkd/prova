<?php

namespace QuestoesProva\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;
use Estrutura\Helpers\Cript;

class QuestoesProvaController extends AbstractCrudController {

    /**
     * @var \QuestoesProva\Service\QuestoesProva
     */
    protected $service;

    /**
     * @var \QuestoesProva\Form\QuestoesProva
     */
    protected $form;

    public function __construct() {
        parent::init();
    }

    public function indexAction() {
        return parent::index($this->service, $this->form);
    }

    public function gravarAction() {
        $controller = $this->params('controller');
        $this->addSuccessMessage('Registro salvo com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
        return parent::gravar($this->service, $this->form);
    }

    public function cadastroAction() {
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction() {
        return parent::excluir($this->service, $this->form);
    }

    public function detalharQuestoesPaginationAction() {

        $request = $this->getRequest();

        $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

        $camposFilter = [
            '0' => [
            //'filter' => "periodoletivodetalhe.nm_sacramento LIKE ?",
            ],
        ];

        $paginator = $this->service->getDetalharQuestoesPaginator($post);

        foreach ($paginator as $key => $item) {
            $checkbox = new \Zend\Form\Element\Checkbox($item["id_questao"]);
            $this->form->add($checkbox);
        }

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
                current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $limit = $post['nr_questoes'] ? $post['nr_questoes'] : $this->getCountPerPage(
                        current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($limit)->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'paginator' => $paginator,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'id_prova' => $post['id'],
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }

    public function adicionarQuestaoProvaManualAction() {
        try {
            $request = $this->getRequest();

            $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

            $errors = $this->service->getTable()->gravarQuestaoProvaManual($post);

            if ($errors instanceof \Zend\Db\Adapter\Exception\InvalidQueryException) {
                throw $errors;
            }

            $this->addSuccessMessage('Questões adicionadas manualmente com sucesso!');

            $this->redirect()->toRoute('navegacao', array('controller' => 'prova-prova', 'action' => 'adicionar-questao-manual', 'id' => Cript::enc($post['id_prova'])));
        } catch (\Zend\Db\Adapter\Exception\InvalidQueryException $ex) {
            $this->addErrorMessage($ex->getMessage());

            $this->redirect()->toRoute('navegacao', array('controller' => 'prova-prova', 'action' => 'adicionar-questao-manual', 'id' => Cript::enc($post['id_prova'])));
        }
    }

}
