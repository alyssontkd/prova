<?php

namespace Questao\Controller;

use Estrutura\Controller\AbstractCrudController;

use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class QuestaoController extends AbstractQuestaoController
{
    /**
     * @var \Questao\Service\Questao
     */
    protected $service;

    /**
     * @var \Questao\Form\Questao
     */
    protected $form;

    public function __construct()
    {
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }


    public function indexPaginationAction()
    {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/

        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => [
                'filter' => "questao.tx_enunciado LIKE ?",
            ],
            '1' => [
                'filter' => "nivel_dificuldade.nm_nivel_dificuldade LIKE ?",
            ],
            '2' => [
                'filter' => "assunto_materia.nm_assunto_materia LIKE ?",
            ],
//            '3' => [
//                'filter' => "temporizacao.nm_temporizacao LIKE ?",
//            ],
//            '4' => [
//                'filter' => "tipo_questao.nm_tipo_questao LIKE ?",
//            ],
//            '5' => [
//                'filter' => "assunto_materia.nm_assunto_materia LIKE ?",
//            ],
            '3' => [
                'filter' => "assunto_materia.nm_assunto_materia LIKE ?",
            ],
//            '7' => [
//                'filter' => "questao.tx_caminho_imagem_questao LIKE ?",
//            ],
            '4' => NULL,
        ];
        $paginator = $this->service->getQuestaoPaginator($filter, $camposFilter);

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
        return parent::gravar($this->service, $this->form);
    }

    public function gravarViaProvaAction()
    {
        return parent::gravarViaProva($this->service, $this->form);
    }

    public function cadastroAction()
    {
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    public function cadastroAlternativasAction()
    {
        try {
            //recuperar o id do Periodo Letivo
            $id_questao = Cript::dec($this->params('id'));

            $questao = new \Questao\Service\QuestaoService();
            $dadosQuestao = $questao->buscar($id_questao);

            $alternativaService = new \AlternativaQuestao\Service\AlternativaQuestaoService();
            $alternativaForm = new \AlternativaQuestao\Form\AlternativaQuestaoCustomizadaForm();

            $arrResultado = $alternativaService->fetchAllById(array('id_questao' => $id_questao));

            $dadosView = [
                'service' => $alternativaService,
                'form' => $alternativaForm,
                'controller' => $this->params('controller'),
                'atributos' => array(),
                'id_questao' => $id_questao,
                'dadosQuestao' => $dadosQuestao,
                'dadosAlternativasQuestao' => $arrResultado,
            ];

            return new ViewModel($dadosView);
        } catch (\Exception $e) {
            $this->addErrorMessage($e->getMessage());
            return false;
        }
    }

    public function gravarAlternativasAction()
    {
        try {
            $controller = $this->params('controller');
            $id = $this->getRequest()->getPost()->get('id');
            $id_questao = $this->getRequest()->getPost()->get('id_questao');
            $this->getRequest()->getPost()->set('id', Cript::enc($id_questao));
            $resultQuestao = parent::gravar(
                $this->getServiceLocator()->get('\Questao\Service\QuestaoService'), new \Questao\Form\QuestaoForm()
            );
            $this->getRequest()->getPost()->set('id', $id);
            if ($resultQuestao) {
                $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $this->getRequest()->getPost()->toArray());

                $files = $this->getRequest()->getFiles();
                $upload = $this->uploadFile($files);

                $post = array_merge($post, $upload);

                if (isset($post['id']) && $post['id']) {
                    $post['id'] = Cript::dec($post['id']);
                }

                $alternativaService = new \AlternativaQuestao\Service\AlternativaQuestaoService();
                $alternativaService->setIdQuestao($id_questao);
                $alternativaService->excluir();
                for ($i = 1; $i <= 5; $i++) {
                    $arFormatado['id_alternativa_questao'] = isset($post['id_alternativa_questao_' . $i]) && $post['id_alternativa_questao_' . $i] ? $post['id_alternativa_questao_' . $i] : "";
                    $arFormatado['tx_alternativa_questao'] = isset($post['tx_alternativa_questao_' . $i]) && $post['tx_alternativa_questao_' . $i] ? $post['tx_alternativa_questao_' . $i] : "";
                    $arFormatado['cs_correta'] = isset($post['cs_correta_' . $i]) && $post['cs_correta_' . $i] ? $post['cs_correta_' . $i] : "";
                    $arFormatado['tx_justificativa'] = isset($post['tx_justificativa_' . $i]) && $post['tx_justificativa_' . $i] ? $post['tx_justificativa_' . $i] : "";

                    $this->getRequest()->getPost()->set('id_alternativa_questao', $arFormatado['id_alternativa_questao']);
                    $this->getRequest()->getPost()->set('id_questao', $id_questao);
                    $this->getRequest()->getPost()->set('tx_alternativa_questao', $arFormatado['tx_alternativa_questao']);
                    $this->getRequest()->getPost()->set('cs_correta', $arFormatado['cs_correta']);
                    $this->getRequest()->getPost()->set('tx_justificativa', $arFormatado['tx_justificativa']);
                    $this->getRequest()->getPost()->set('id_usuario_cadastro', $this->getServiceLocator()->get('Auth\Table\MyAuth')->read()->id_usuario);
                    $this->getRequest()->getPost()->set('id_usuario_alteracao', $this->getServiceLocator()->get('Auth\Table\MyAuth')->read()->id_usuario);

                    $resultAlternativa = AbstractCrudController::gravar(
                        $this->getServiceLocator()->get('\AlternativaQuestao\Service\AlternativaQuestaoService'), new \AlternativaQuestao\Form\AlternativaQuestaoForm()
                    );
                }

                return $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
            }
        } catch (\Exception $e) {
            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return false;
        }

    }

    public function cadastroViaProvaAction()
    {
        $service = new \Questao\Service\QuestaoService();
        $form = new \Questao\Form\QuestaoForm();

        $id_questao = Cript::dec($this->params()->fromRoute('id'));
        $id_prova = Cript::dec($this->params()->fromRoute('id_prova'));

        if ($id_questao) {
            $form->setData($service->buscar($id_questao)->toArray());
        }

        $dadosView = [
            'service' => $service,
            'form' => $form,
            'controller' => $this->params('controller'),
            'id_prova' => $id_prova,
            'id_questao' => $id_questao,
            'atributos' => []
        ];

        return new ViewModel($dadosView);
    }

    public function cadastroAlternativasViaProvaAction()
    {
        try {
            //recuperar o id do Periodo Letivo
            $id_questao = Cript::dec($this->params('id'));
            $id_prova = Cript::dec($this->params('id_prova'));

            $questao = new \Questao\Service\QuestaoService();
            $dadosQuestao = $questao->buscar($id_questao);

            $alternativaService = new \AlternativaQuestao\Service\AlternativaQuestaoService();
            $alternativaForm = new \AlternativaQuestao\Form\AlternativaQuestaoCustomizadaForm();

            $arrResultado = $alternativaService->fetchAllById(array('id_questao' => $id_questao));

            $dadosView = [
                'service' => $alternativaService,
                'form' => $alternativaForm,
                'controller' => $this->params('controller'),
                'atributos' => array(),
                'id_questao' => $id_questao,
                'id_prova' => $id_prova,
                'dadosQuestao' => $dadosQuestao,
                'dadosAlternativasQuestao' => $arrResultado,
            ];

            return new ViewModel($dadosView);
        } catch (\Exception $e) {
            $this->addErrorMessage($e->getMessage());
            return false;
        }
    }

    public function gravarAlternativasViaProvaAction()
    {
        try {
            $controller = $this->params('controller');
            $id = $this->getRequest()->getPost()->get('id');
            $id_questao = $this->getRequest()->getPost()->get('id_questao');
            $id_prova = $this->getRequest()->getPost()->get('id_prova');

            $this->getRequest()->getPost()->set('id', Cript::enc($id_questao));
            $resultQuestao = parent::gravar(
                $this->getServiceLocator()->get('\Questao\Service\QuestaoService'), new \Questao\Form\QuestaoForm()
            );
            $this->getRequest()->getPost()->set('id', $id);
            if ($resultQuestao) {
                $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $this->getRequest()->getPost()->toArray());

                $files = $this->getRequest()->getFiles();
                $upload = $this->uploadFile($files);

                $post = array_merge($post, $upload);

                if (isset($post['id']) && $post['id']) {
                    $post['id'] = Cript::dec($post['id']);
                }

                $alternativaService = new \AlternativaQuestao\Service\AlternativaQuestaoService();
                $alternativaService->setIdQuestao($id_questao);
                $alternativaService->excluir();
                for ($i = 1; $i <= 5; $i++) {
                    $arFormatado['id_alternativa_questao'] = isset($post['id_alternativa_questao_' . $i]) && $post['id_alternativa_questao_' . $i] ? $post['id_alternativa_questao_' . $i] : "";
                    $arFormatado['tx_alternativa_questao'] = isset($post['tx_alternativa_questao_' . $i]) && $post['tx_alternativa_questao_' . $i] ? $post['tx_alternativa_questao_' . $i] : "";
                    $arFormatado['cs_correta'] = isset($post['cs_correta_' . $i]) && $post['cs_correta_' . $i] ? $post['cs_correta_' . $i] : "";
                    $arFormatado['tx_justificativa'] = isset($post['tx_justificativa_' . $i]) && $post['tx_justificativa_' . $i] ? $post['tx_justificativa_' . $i] : "";

                    $this->getRequest()->getPost()->set('id_alternativa_questao', $arFormatado['id_alternativa_questao']);
                    $this->getRequest()->getPost()->set('id_questao', $id_questao);
                    $this->getRequest()->getPost()->set('tx_alternativa_questao', $arFormatado['tx_alternativa_questao']);
                    $this->getRequest()->getPost()->set('cs_correta', $arFormatado['cs_correta']);
                    $this->getRequest()->getPost()->set('tx_justificativa', $arFormatado['tx_justificativa']);
                    $this->getRequest()->getPost()->set('id_usuario_cadastro', $this->getServiceLocator()->get('Auth\Table\MyAuth')->read()->id_usuario);
                    $this->getRequest()->getPost()->set('id_usuario_alteracao', $this->getServiceLocator()->get('Auth\Table\MyAuth')->read()->id_usuario);

                    $resultAlternativa = AbstractCrudController::gravar(
                        $this->getServiceLocator()->get('\AlternativaQuestao\Service\AlternativaQuestaoService'), new \AlternativaQuestao\Form\AlternativaQuestaoForm()
                    );
                }

                return $this->redirect()->toRoute('navegacao', array('controller' => 'prova-prova', 'action' => 'cadastro-questao', 'id' => Cript::enc($id_prova)));
            }
        } catch (\Exception $e) {
            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return false;
        }

    }
}
