<?php

namespace FiltroProva\Controller;

use Estrutura\Controller\AbstractCrudController;

class FiltroProvaController extends AbstractCrudController
{
    /**
     * @var \FiltroProva\Service\FiltroProva
     */
    protected $service;

    /**
     * @var \FiltroProva\Form\FiltroProva
     */
    protected $form;

    public function __construct(){
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    public function gravarAction(){
        #Alysson
        $this->addSuccessMessage('Registro gravado com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => 'filtro_prova-filtroprova', 'action' => 'index'));
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
}
