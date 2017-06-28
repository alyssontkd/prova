<?php

namespace AssuntoMateria\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;


class AssuntoMateriaController extends AbstractCrudController
{
    /**
     * @var \Action\Service\Action
     */
    protected $service;

    /**
     * @var \Action\Form\Action
     */
    protected $form;

    public function __construct()
    {
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
                'filter' => "assunto_materia.nm_assunto_materia LIKE ?",
            ],
            '1' => [
                'filter' => "materia.nm_materia LIKE ?",
            ],
            '2' => [
                'filter' => "classificacao_semestre.nm_classificacao_semestre LIKE ?",
            ],
            '3' => NULL
        ];


        $paginator = $this->service->getAssuntoMateriaPaginator($filter, $camposFilter);

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
        try {
            $request = $this->getRequest();

            $controller = $this->params('controller');
            $service = $this->service;
            $form = $this->form;

            if (!$request->isPost()) {
                throw new \Exception('Dados Inválidos');
            }

            $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

            $assuntoMateriaService = new \AssuntoMateria\Service\AssuntoMateriaService();
            $assuntoMateriaService->setNmAssuntoMateria(trim($this->getRequest()->getPost()->get('nm_assunto_materia')));
            if ($assuntoMateriaService->filtrarObjeto()->count()) {
                $this->setPost($post);
                $this->addErrorMessage('Assunto já cadastrado.');
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
                return FALSE;
            }

            $files = $request->getFiles();
            $upload = $this->uploadFile($files);

            $post = array_merge($post, $upload);

            if (isset($post['id']) && $post['id']) {
                $post['id'] = \Estrutura\Helpers\Cript::dec($post['id']);
            }

            #xd($post);
            #$assuntoMateriaService = new \AssuntoMateria\Service\AssuntoMateriaService();
            $assuntoMateriaService->setIdMateria(trim($this->getRequest()->getPost()->get('id_materia')));
            $assuntoMateriaService->setNmAssuntoMateria(trim($this->getRequest()->getPost()->get('nm_assunto_materia')));

            #xd($assuntoMateriaService->filtrarObjeto()->count());
            if ($assuntoMateriaService->filtrarObjeto()->count()) {
                $this->addErrorMessage('O Assunto informado já foi cadastrado para esta disciplina.');
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
                return FALSE;
            }

            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
                return false;
            }

            $service->exchangeArray($form->getData());
            $this->addSuccessMessage('Assunto cadastrado com sucesso!');
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
            return $service->salvar();

        } catch (\Exception $e) {

            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return false;
        }

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
        $id_assunto_materia = $this->params('id');

        if (isset($id_assunto_materia) && $id_assunto_materia) {
            $id_assunto_materia = \Estrutura\Helpers\Cript::dec($id_assunto_materia);
        } else {
            $this->addErrorMessage('ID não informado');
            return $this->redirect()->toRoute('navegacao', ['controller' => $controller, 'action' => 'index']);
        }
        $assuntoMateriaService = new \AssuntoMateria\Service\AssuntoMateriaService();
        $assuntoMateriaEntity = $assuntoMateriaService->buscar($id_assunto_materia);

        if (1 == $auth->id_perfil) { //Se o usuario logado for Administrador
            $assuntoMateriaEntity->setCsAtivo(0); // Valor '0' desabilita o campo cs_ativo
            $assuntoMateriaEntity->salvar();
        }
        $this->addSuccessMessage('Assunto excluido com sucesso.');
        return $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
    }
}
