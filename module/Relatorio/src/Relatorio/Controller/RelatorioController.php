<?php

namespace Relatorio\Controller;

use Estrutura\Controller\AbstractCrudController;
use DOMPDFModule\View\Model\PdfModel;

class RelatorioController extends AbstractCrudController {

    /**
     * @var \Action\Service\Action
     */
    protected $service;

    public function __construct() {
        parent::setServiceObj();
    }

    public function gerarPdfQuantitativoQuestoesPorAssuntoAction() {
        $pdf = new PdfModel();

        $pdf->setOption('filename', 'quantitativo-questoes-por-assunto.pdf');
        $pdf->setOption('paperSize', 'a4');
        $pdf->setOption('paperOrientation', 'portrait');

        $resultado = $this->service->getQuantitativoQuestoesPorAssunto();

        $pdf->setVariables(array(
            'resultado' => $resultado
        ));

        return $pdf;
    }

    public function relatorioUsuarios() {
        $pdf = new PdfModel();

        $pdf->setOption('filename', 'relatorio-usuario.pdf');
        $pdf->setOption('paperSize', 'a4');
        $pdf->setOption('paperOrientation', 'portrait');

        $resultado = $this->service->getUsuarioPerfis();

        $pdf->setVariables(array(
                //'nm_usaurio' => $usuario,
                //'nm_perfil' => $perfil,
        ));
    }

    public function gerarPdfMateriaSemestreAction() {
        $pdf = new PdfModel();

        $pdf->setOption('filename', 'Materia-semestre.pdf');
        $pdf->setOption('paperSize', 'a4');
        $pdf->setOption('paperOrientation', 'portrait');

        $resultado = $this->service->getMateriasSemestre();

        $pdf->setVariables(array(
            'resultado' => $resultado
        ));

        return $pdf;
    }

}
