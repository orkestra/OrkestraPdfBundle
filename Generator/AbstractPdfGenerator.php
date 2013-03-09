<?php

namespace Orkestra\Bundle\PdfBundle\Generator;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
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
     * Performs the PDF generation
     *
     * @param array $parameters An array of parameters to be used to render the PDF
     * @param array $options    An array of options to be passed to the underlying PdfFactory
     *
     * @return \Orkestra\Bundle\PdfBundle\Pdf\PdfInterface
     */
    abstract protected function doGenerate(array $parameters, array $options);

    /**
     * Generates a new PDF
     *
     * @param array $parameters An array of parameters to be used to render the PDF
     * @param array $options    An array of options to be passed to the underlying PdfFactory
     *
     * @return \Orkestra\Bundle\PdfBundle\Pdf\PdfInterface
     */
    public function generate(array $parameters = array(), array $options = array())
    {
        $parametersResolver = new OptionsResolver();
        $this->setDefaultParameters($parametersResolver);

        $parameters = $parametersResolver->resolve($parameters);

        $optionsResolver = new OptionsResolver();
        $this->setDefaultOptions($optionsResolver);

        $options = $optionsResolver->resolve($options);

        return $this->doGenerate($parameters, $options);
    }

    /**
     * Creates a new PDF with the given options
     *
     * @param array $options
     *
     * @return \Orkestra\Bundle\PdfBundle\Pdf\PdfInterface
     */
    protected function createPdf(array $options)
    {
        return $this->pdfFactory->create($options);
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

    /**
     * Set allowed, required and default parameters
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    protected function setDefaultParameters(OptionsResolverInterface $resolver)
    {
    }

    /**
     * Set allowed, required and default options
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array(
            'creator',
            'author',
            'title',
            'subject',
            'keywords',
            'defaultMonospacedFont',
            'imageScale',
            'languageArray',
            'font',
        ));

        $resolver->setDefaults(array(
            'orientation' => 'P',
            'unit' => 'mm',
            'format' => 'USLETTER',
            'unicode' => true,
            'encoding' => 'UTF-8',
            'diskcache' => true,
            'pdfa' => false,
            'printHeader' => false,
            'printFooter' => false,
            'margins' => array(15, 27, 15),
            'autoPageBreak' => array(true, 25),
        ));
    }
}
