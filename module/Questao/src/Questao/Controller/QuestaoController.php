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
                'filter' => "questao.nm_titulo_questao LIKE ?",
            ],
            '1' => [
                'filter' => "questao.tx_enunciado LIKE ?",
            ],
            '2' => [
                'filter' => "nivel_dificuldade.nm_nivel_dificuldade LIKE ?",
            ],
            '3' => [
                'filter' => "materia.nm_materia LIKE ?",
            ],
            '4' => [
                'filter' => "assunto_materia.nm_assunto_materia LIKE ?",
            ],
            '5' => NULL,
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
        $controller = $this->params('controller');
        $id_questao = Cript::dec($this->getRequest()->getPost()->get('id'));

        $pos = $this->getRequest()->getPost()->toArray();

        if (isset($id_questao) && $id_questao) {
            $this->atualizarAction();
            return FALSE;
        }

        $this->getRequest()->getPost()->set('id_usuario_cadastro', $this->getServiceLocator()->get('Auth\Table\MyAuth')->read()->id_usuario);
        $this->getRequest()->getPost()->set('id_usuario_alteracao', $this->getServiceLocator()->get('Auth\Table\MyAuth')->read()->id_usuario);
        $this->getRequest()->getPost()->set('id_classificacao_semestre', $this->getRequest()->getPost()->get('id_classificacao_semestre'));
        $this->getRequest()->getPost()->set('id_nivel_dificuldade', $this->getRequest()->getPost()->get('id_nivel_dificuldade'));
        $this->getRequest()->getPost()->set('id_temporizacao', $this->getRequest()->getPost()->get('id_temporizacao'));
        $this->getRequest()->getPost()->set('id_tipo_questao', $this->getRequest()->getPost()->get('id_tipo_questao'));
        $this->getRequest()->getPost()->set('id_fonte_questao', $this->getRequest()->getPost()->get('id_fonte_questao'));
        $this->getRequest()->getPost()->set('id_assunto_materia', $this->getRequest()->getPost()->get('id_assunto_materia'));
        $this->getRequest()->getPost()->set('bo_utilizavel', $this->getRequest()->getPost()->get('bo_utilizavel'));
        $this->getRequest()->getPost()->set('nm_titulo_questao', $this->getRequest()->getPost()->get('nm_titulo_questao'));
        $this->getRequest()->getPost()->set('tx_enunciado', $this->getRequest()->getPost()->get('tx_enunciado'));
        $this->getRequest()->getPost()->set('bo_ativo', $this->getRequest()->getPost()->get('bo_ativo'));
        $this->getRequest()->getPost()->set('bo_utilizavel', $this->getRequest()->getPost()->get('bo_utilizavel'));
        #$this->getRequest()->getPost()->set('tx_caminho_imagem_questao',$this->getRequest()->getPost()->get('tx_caminho_imagem_questao'));

        $resultQuestao = parent::gravar(
            $this->getServiceLocator()->get('\Questao\Service\QuestaoService'), new \Questao\Form\QuestaoForm()
        );
        if ($resultQuestao) {


            try {

                #$controller = $this->params('controller');
                #$id = $this->getRequest()->getPost()->get('id');
                #$id_questao = $this->getRequest()->getPost()->get('id_questao');
                #$this->getRequest()->getPost()->set('id', Cript::enc($id_questao));
                #$resultQuestao = parent::gravar(
                #   $this->getServiceLocator()->get('\Questao\Service\QuestaoService'), new \Questao\Form\QuestaoForm()
                #);
                # $this->getRequest()->getPost()->set('id', $id);
                if ($resultQuestao) {
                    $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $this->getRequest()->getPost()->toArray());

                    # $files = $this->getRequest()->getFiles();
                    #$upload = $this->uploadFile($files);

                    #$post = array_merge($post, $upload);

                    #if (isset($post['id']) && $post['id']) {
                    #   $post['id'] = Cript::dec($post['id']);
                    #}

                    #$alternativaService = new \AlternativaQuestao\Service\AlternativaQuestaoService();
                    #$alternativaService->setIdQuestao($id_questao);
                    #$alternativaService->excluir();
                    for ($i = 1; $i <= 5; $i++) {
                        $arFormatado['id_alternativa_questao'] = isset($post['id_alternativa_questao_' . $i]) && $post['id_alternativa_questao_' . $i] ? $post['id_alternativa_questao_' . $i] : "";
                        $arFormatado['tx_alternativa_questao'] = isset($post['tx_alternativa_questao_' . $i]) && $post['tx_alternativa_questao_' . $i] ? $post['tx_alternativa_questao_' . $i] : "";
                        # $arFormatado['id_questao'] = isset($post['tx_alternativa_questao_' . $i]) && $post['tx_alternativa_questao_' . $i] ? $post['tx_alternativa_questao_' . $i] : "";
                        $arFormatado['cs_correta'] = isset($post['cs_correta_' . $i]) && $post['cs_correta_' . $i] ? $post['cs_correta_' . $i] : "";
                        $arFormatado['tx_justificativa'] = isset($post['tx_justificativa_' . $i]) && $post['tx_justificativa_' . $i] ? $post['tx_justificativa_' . $i] : "";
                        $this->getRequest()->getPost()->set('id_questao', $resultQuestao);
                        $this->getRequest()->getPost()->set('id_alternativa_questao', $arFormatado['id_alternativa_questao']);

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


    }

    public function gravarViaProvaAction()
    {
        return parent::gravarViaProva($this->service, $this->form);
    }

    public function cadastroAction()
    {
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
    }

    public function excluirAction($option = null)
    {

        $id = Cript::dec($this->params('id'));
        if (!empty($option)) {
            $id = Cript::dec($option);
        }
        if (isset($id) && $id) {
            $obQuestao = new \Questao\Service\QuestaoService();
            $arrQuestao = $obQuestao->getQuestaoToArray($id);

            ##############Excluindo dados da tabela filha###############
            $objAlternativaQuestao = new \AlternativaQuestao\Service\AlternativaQuestaoService();
            $objAlternativaQuestao->setIdQuestao($arrQuestao['id_questao']);
            $objAlternativaQuestao->excluir();


            $retornoExcluir = parent::excluir($this->service, $this->form);


        }

        return $retornoExcluir;


    }

    public function atualizarAction()
    {
        try {


            $controller = $this->params('controller');
            $post = $this->getRequest()->getPost()->toArray();
            $id = Cript::dec($post['id']);
            $post['id'] = $id;
            $objQuestao = new \Questao\Service\QuestaoService();

            $objQuestao->setId($post['id_questao']);
            $objQuestao->setIdClassificacaoSemestre($post['id_classificacao_semestre']);
            $objQuestao->setIdNivelDificuldade($post['id_nivel_dificuldade']);
            $objQuestao->setIdTemporizacao($post['id_temporizacao']);
            $objQuestao->setIdFonteQuestao($post['id_fonte_questao']);
            $objQuestao->setIdAssuntoMateria($post['id_assunto_materia']);
            $objQuestao->setNmTituloQuestao($post['nm_titulo_questao']);
            $objQuestao->setTxEnunciado($post['tx_enunciado']);

            $objQuestao->setIdUsuarioAlteracao($this->getServiceLocator()->get('Auth\Table\MyAuth')->read()->id_usuario);
            $objQuestao->salvar();


            $objAlternativaQuestao = new \AlternativaQuestao\Service\AlternativaQuestaoService();
            for ($a = 1; $a <= 5; $a++) {

                $objAlternativaQuestao->setId($post['id_alternativa_questao_' . $a]);
                $objAlternativaQuestao->setTxAlternativaQuestao($post['tx_alternativa_questao_' . $a]);
                $objAlternativaQuestao->setCsCorreta($post['cs_correta_' . $a]);
                $objAlternativaQuestao->setTxJustificativa($post['tx_justificativa_' . $a]);
                $objAlternativaQuestao->setIdQuestao($post['id_questao']);
                $objAlternativaQuestao->setIdUsuarioAlteracao($this->getServiceLocator()->get('Auth\Table\MyAuth')->read()->id_usuario);
                $objAlternativaQuestao->salvar();
            }

            $this->addSuccessMessage('Questão atualizada com sucesso.');
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));

        } catch (\Exception $e) {

            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return FALSE;
        }
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

            $arrResultado = $alternativaService->fetchAllById(['id_questao' => $id_questao]);

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

    public function carregarComboMateriasAjaxAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost()) {
            throw new \Exception('Dados Inválidos');
        }
        $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());
        $id_classificacao_semestre = $post['id_classificacao_semestre'];

        #Recupera os materias cadastradas por semestre
        $materiaSemestreService = new \MateriaSemestre\Service\MateriaSemestreService();
        $arMaterias = $materiaSemestreService->carregarMateriaPorSemestreParaCombo($id_classificacao_semestre);


        #Faz o Tratamento do Array para enviar para View
        $arMateriasCombo = array();
        $materiaService = new \Materia\Service\MateriaService();
        foreach ($arMaterias as $key => $item) {
            $obDadosMateria = $materiaService->buscar($item['id_materia']);
            $arMateriasCombo[$key]['id'] = $obDadosMateria->getId();
            $arMateriasCombo[$key]['descricao'] = $obDadosMateria->getNmMateria();
        }

        if (count($arMateriasCombo) > 0) {
            $valuesJson = new JsonModel(array('ar_materias' => $arMateriasCombo, 'sucesso' => true, 'id_classificacao_semestre' => $id_classificacao_semestre));
        } else {
            $arMateriasCombo[0]['id'] = "";
            $arMateriasCombo[0]['descricao'] = 'Não Existem Matérias cadastradas';
            $valuesJson = new JsonModel(array('ar_materias' => $arMateriasCombo, 'sucesso' => true, 'id_classificacao_semestre' => $id_classificacao_semestre));
        }

        return $valuesJson;

    }

    public function carregarComboAssuntoMateriaAjaxAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost()) {
            throw new \Exception('Dados Inválidos');
        }
        $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());
        $id_materia = $post['id_materia'];
        #xd($post);

        #Recupera os materias cadastradas por semestre
        $assuntoMateriaService = new \AssuntoMateria\Service\AssuntoMateriaService();
        $arAssuntoMaterias = $assuntoMateriaService->carregarAssuntoPorMateriaParaCombo($id_materia);

        #Faz o Tratamento do Array para enviar para View
        $arAssuntoMateriaCombo = array();
        foreach ($arAssuntoMaterias as $key => $item) {
            if (isset($item['id_assunto_materia']) && isset($item['nm_assunto_materia']) && $item['id_assunto_materia'] && $item['nm_assunto_materia']) {
                $arAssuntoMateriaCombo[$key]['id'] = $item['id_assunto_materia'];
                $arAssuntoMateriaCombo[$key]['descricao'] = $item['nm_assunto_materia'];
            }
        }
        if (count($arAssuntoMateriaCombo) > 0) {
            $valuesJson = new JsonModel(array('ar_assunto_materia' => $arAssuntoMateriaCombo, 'sucesso' => true, 'id_materia' => $id_materia));
        } else {
            $arAssuntoMateriaCombo[0]['id'] = "";
            $arAssuntoMateriaCombo[0]['descricao'] = 'Não Existem Assuntos cadastrados';
            $valuesJson = new JsonModel(array('ar_assunto_materia' => $arAssuntoMateriaCombo, 'sucesso' => true, 'id_materia' => $id_materia));
        }
        return $valuesJson;
    }

    public function carregarComboSubAssuntoMateriaAjaxAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost()) {
            throw new \Exception('Dados Inválidos');
        }
        $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());
        $id_assunto_materia = $post['id_assunto_materia'];
        #xd($post);
        #Recupera os materias cadastradas por semestre
        $subAssuntoMateriaService = new \SubAssuntoMateria\Service\SubAssuntoMateriaService();
        $arSubAssuntoMaterias = $subAssuntoMateriaService->fetchAllByArrayAtributo(['id_assunto_materia' => $id_assunto_materia, 'cs_ativo' => 1]);

        #Faz o Tratamento do Array para enviar para View
        $arSubAssuntoMateriaCombo = array();
        foreach ($arSubAssuntoMaterias as $key => $item) {
            if (isset($item['id_sub_assunto_materia']) && isset($item['nm_sub_assunto_materia']) && $item['id_sub_assunto_materia'] && $item['nm_sub_assunto_materia']) {
                $arSubAssuntoMateriaCombo[$key]['id'] = $item['id_sub_assunto_materia'];
                $arSubAssuntoMateriaCombo[$key]['descricao'] = $item['nm_sub_assunto_materia'];
            }
        }

        if (count($arSubAssuntoMateriaCombo) > 0) {
            $valuesJson = new JsonModel(array('ar_sub_assunto_materia' => $arSubAssuntoMateriaCombo, 'sucesso' => true, 'id_assunto_materia' => $id_assunto_materia));
        } else {
            $arSubAssuntoMateriaCombo[0]['id'] = "";
            $arSubAssuntoMateriaCombo[0]['descricao'] = 'Não Existem Assuntos cadastrados';
            $valuesJson = new JsonModel(array('ar_sub_assunto_materia' => $arSubAssuntoMateriaCombo, 'sucesso' => true, 'id_assunto_materia' => $id_assunto_materia));
        }

        return $valuesJson;

    }

    public function excluirLogAction(){

        $auth = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        $controller = $this->params('controller');
        $id_questao = $this->params('id');

        if (isset($id_questao) && $id_questao) {
            $id_questao = \Estrutura\Helpers\Cript::dec($id_questao);
        } else {
            $this->addErrorMessage('ID não informado');
            return $this->redirect()->toRoute('navegacao', ['controller' => $controller, 'action' => 'index']);
        }
        $questaoService = new \Questao\Service\QuestaoService();
        $questaoEntity = $questaoService->buscar($id_questao);

        if (1 == $auth->id_perfil) { //Se o usuario logado for Administrador
            $questaoEntity->setCsAtivo(0); // Valor '0' desabilita o campo cs_ativo
            $questaoEntity->salvar();
        }
        $this->addSuccessMessage('Questão excluida com sucesso.');
        return $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
    }

}
