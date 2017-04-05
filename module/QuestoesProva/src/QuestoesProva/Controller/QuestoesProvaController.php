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
        $request = $this->getRequest();

        $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

        try {
            $errors = $this->service->getTable()->gravarQuestaoProvaManual($post);

            if ($errors instanceof \Zend\Db\Adapter\Exception\InvalidQueryException) {
                throw $errors;
            }

            $this->addSuccessMessage('Questões adicionadas manualmente com sucesso!');

            return $this->redirect()->toRoute('navegacao', array('controller' => 'prova-prova', 'action' => 'adicionar-questao-manual', 'id' => Cript::enc($post['id_prova'])));
        } catch (\Zend\Db\Adapter\Exception\InvalidQueryException $ex) {
            $this->addErrorMessage($ex->getMessage());

            return $this->redirect()->toRoute('navegacao', array('controller' => 'prova-prova', 'action' => 'adicionar-questao-manual', 'id' => Cript::enc($post['id_prova'])));
        }
    }

    public function adicionarQuestaoProvaAleatoriaAction() {
        $request = $this->getRequest();

        $post = $request->getPost()->toArray();

        try {
            if (isset($post['id']) && $post['id']) {
                $post['id'] = Cript::dec($post['id']);
            }

            $paginator = $this->service->getDetalharQuestoesPaginator($post);

            $paginator->setItemCountPerPage($paginator->getTotalItemCount());

            $questao = $paginator->getCurrentItems()->toArray();
            
            if (count($questao) < $post['nr_questoes']) {
                $this->addErrorMessage('Número de questões maior que o número de questões não adicionadas à prova!');

                return $this->redirect()->toRoute('navegacao', array('controller' => 'prova-prova', 'action' => 'adicionar-questao-aleatoria', 'id' => Cript::enc($post['id'])));
            }

            $error = $this->service->getTable()->gravarQuestaoProvaAleatoria($questao, $post);

            if ($error instanceof \Zend\Db\Adapter\Exception\InvalidQueryException) {
                throw $error;
            }

            $this->addSuccessMessage('Questões adicionadas aleatoriamente com sucesso!');

            return $this->redirect()->toRoute('navegacao', array('controller' => 'prova-prova', 'action' => 'cadastro-questao', 'id' => Cript::enc($post['id'])));
        } catch (\Zend\Db\Adapter\Exception\InvalidQueryException $ex) {
            $this->addErrorMessage($ex->getMessage());

            return $this->redirect()->toRoute('navegacao', array('controller' => 'prova-prova', 'action' => 'adicionar-questao-aleatoria', 'id' => Cript::enc($post['id'])));
        }
    }

}
