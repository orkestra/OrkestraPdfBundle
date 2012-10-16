<?php

namespace Orkestra\Bundle\PdfBundle\Helper;

use Symfony\Component\Templating\EngineInterface;
use Orkestra\Bundle\PdfBundle\Factory\PdfFactoryInterface;

class PdfHelper
{
    /**
     * @var \Orkestra\Bundle\PdfBundle\Factory\PdfFactoryInterface
     */
    protected $pdfFactory;

    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    protected $templatingEngine;

    /**
     * Constructor
     *
     * @param \Orkestra\Bundle\PdfBundle\Factory\PdfFactoryInterface $pdfFactory
     * @param \Symfony\Component\Templating\EngineInterface $templatingEngine
     */
    public function __construct(PdfFactoryInterface $pdfFactory, EngineInterface $templatingEngine)
    {
        $this->pdfFactory = $pdfFactory;
        $this->templatingEngine = $templatingEngine;
    }

    /**
     * Renders a PDF using the Templating engine
     *
     * @param string $name       The name of the template
     * @param array $parameters  An array of parameters to pass to the template
     * @param array $options     Options to be used when creating the new PDF
     *
     * @return \TCPDF
     */
    public function renderPdf($name, array $parameters = array(), array $options = array())
    {
        $html = $this->templatingEngine->render($name, $parameters);

        $pdf = $this->pdfFactory->create($options);

        $pdf->writeHTML($html);

        return $pdf;
    }
}
