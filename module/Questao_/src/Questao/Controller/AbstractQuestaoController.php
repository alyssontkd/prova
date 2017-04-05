<?php

/**
 * Classe de abstração para as controllers de crud do sistema
 * Define as funções principais dos cruds do sistema
 */

namespace Questao\Controller;
use Estrutura\Controller\AbstractCrudController;

use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Estrutura\Helpers\Cript;

abstract class AbstractQuestaoController extends AbstractCrudController
{

    public function gravar($service, $form)
    {
        try {
            $controller = $this->params('controller');
            $request = $this->getRequest();

            if (!$request->isPost()) {
                throw new \Exception('Dados Inválidos');
            }

            $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

            $files = $request->getFiles();
            $upload = $this->uploadFile($files);

            $post = array_merge($post, $upload);

            if (isset($post['id']) && $post['id']) {
                $post['id'] = Cript::dec($post['id']);
            }

            if (empty($post['id'])) {
                $post['id_usuario_cadastro'] = $this->getServiceLocator()->get('Auth\Table\MyAuth')->read()->id_usuario;
                $post['id_usuario_alteracao'] = $this->getServiceLocator()->get('Auth\Table\MyAuth')->read()->id_usuario;
            } else {
                $post['id_usuario_alteracao'] = $this->getServiceLocator()->get('Auth\Table\MyAuth')->read()->id_usuario;
            }

            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
                return false;
            }

            $service->exchangeArray($form->getData());
            $this->addSuccessMessage('Registro gravado com sucesso.');
            $id_questao = $service->salvar();

            //Define o redirecionamento
            if (isset($post['id']) && $post['id']) {
                $this->redirect()->toRoute('rota_questao', array('controller' => $controller, 'action' => 'cadastro-alternativas', 'id' => Cript::enc($post['id'])));
            } else {
                $this->redirect()->toRoute('rota_questao', array('controller' => $controller, 'action' => 'cadastro-alternativas', 'id' => Cript::enc($id_questao)));
            }

            return $id_questao;
        } catch (\Exception $e) {

            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return false;
        }
    }

    public function gravarViaProva($service, $form)
    {
        try {
            $controller = $this->params('controller');
            $request = $this->getRequest();

            if (!$request->isPost()) {
                throw new \Exception('Dados Inválidos');
            }

            $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

            $files = $request->getFiles();
            $upload = $this->uploadFile($files);

            $post = array_merge($post, $upload);

            if (isset($post['id']) && $post['id']) {
                $post['id'] = Cript::dec($post['id']);
            }

            if (empty($post['id'])) {
                $post['id_usuario_cadastro'] = $this->getServiceLocator()->get('Auth\Table\MyAuth')->read()->id_usuario;
                $post['id_usuario_alteracao'] = $this->getServiceLocator()->get('Auth\Table\MyAuth')->read()->id_usuario;
            } else {
                $post['id_usuario_alteracao'] = $this->getServiceLocator()->get('Auth\Table\MyAuth')->read()->id_usuario;
            }

            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
                return false;
            }

            $service->exchangeArray($form->getData());
            $this->addSuccessMessage('Registro gravado com sucesso.');
            $id_questao = $service->salvar();

            //Define o redirecionamento
            if (isset($post['id']) && $post['id']) {
                $this->redirect()->toRoute('rota_questao_via_prova', array('controller' => $controller, 'action' => 'cadastro-alternativas-via-prova', 'id' => Cript::enc($post['id']), 'id_prova' => Cript::enc($post['id_prova'])));
            } else {
                $this->redirect()->toRoute('rota_questao_via_prova', array('controller' => $controller, 'action' => 'cadastro-alternativas-via-prova', 'id' => Cript::enc($id_questao), 'id_prova' => Cript::enc($post['id_prova'])));
            }

            return $id_questao;
        } catch (\Exception $e) {

            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return false;
        }
    }

}
