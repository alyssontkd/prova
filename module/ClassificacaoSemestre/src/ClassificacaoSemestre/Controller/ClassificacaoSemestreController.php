<?php

namespace ClassificacaoSemestre\Controller;

use Estrutura\Controller\AbstractCrudController;

class ClassificacaoSemestreController extends AbstractCrudController
{
    /**
     * @var \ClassificacaoSemestre\Service\ClassificacaoSemestre
     */
    protected $service;

    /**
     * @var \ClassificacaoSemestre\Form\ClassificacaoSemestre
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
        return parent::gravar($this->service, $this->form);
    }

    public function cadastroAction()
    {
        
        if ($result = parent::gravar($this->service, $this->form);) {
            
            $this->addSuccessMessage('Registro salvo com sucesso!');
            $this->redirect()->toRoute('navegacao', array(
                'controller' => $controller, 
                'action' => 'index')
            );
        }
        return $result;
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }
}
