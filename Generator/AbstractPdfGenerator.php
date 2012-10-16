<?php

namespace Orkestra\Bundle\PdfBundle\Generator;

use Symfony\Component\Templating\EngineInterface;
use Orkestra\Bundle\PdfBundle\Factory\PdfFactoryInterface;

abstract class AbstractPdfGenerator implements PdfGeneratorInterface
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
     * Uses the underlying Templating engine to render a template
     *
     * @param string $template
     * @param array $parameters
     *
     * @return string
     */
    public function render($template, array $parameters = array())
    {
        return $this->templatingEngine->render($template, $parameters);
    }
}
