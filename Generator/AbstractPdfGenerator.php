<?php

/*
 * This file is part of the OrkestraPdfBundle package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Bundle\PdfBundle\Generator;

use Orkestra\Bundle\PdfBundle\Factory\FactoryRegistryInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Default base class, useful for any PDF generator
 */
abstract class AbstractPdfGenerator implements PdfGeneratorInterface
{
    /**
     * @var \Orkestra\Bundle\PdfBundle\Factory\FactoryRegistryInterface
     */
    protected $factoryRegistry;

    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    protected $templatingEngine;

    /**
     * Constructor
     *
     * @param \Orkestra\Bundle\PdfBundle\Factory\FactoryRegistryInterface $factoryRegistry
     * @param \Symfony\Component\Templating\EngineInterface               $templatingEngine
     */
    public function __construct(FactoryRegistryInterface $factoryRegistry, EngineInterface $templatingEngine)
    {
        $this->factoryRegistry  = $factoryRegistry;
        $this->templatingEngine = $templatingEngine;
    }

    /**
     * Performs the PDF generation
     *
     * Parameters are intended to be passed to the underlying views used to render the PDF
     * Options are intended to be passed to the underlying PDF to configure it
     *
     * @param array $parameters An array of parameters to be used to render the PDF
     * @param array $options    An array of options to configure the generator
     *
     * @return \Orkestra\Bundle\PdfBundle\Pdf\PdfInterface
     */
    abstract protected function doGenerate(array $parameters, array $options);

    /**
     * Generates a new PDF
     *
     * @param array $parameters An array of parameters to be used to render the PDF
     * @param array $options    An array of options to configure the generator
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
     * @param string $type
     * @param array  $options
     *
     * @return \Orkestra\Bundle\PdfBundle\Pdf\PdfInterface
     */
    protected function createPdf($type, array $options = array())
    {
        return $this->factoryRegistry->getFactory($type)->create($options);
    }

    /**
     * Uses the underlying Templating engine to render a template
     *
     * @param string $template
     * @param array  $parameters
     *
     * @return string
     */
    protected function render($template, array $parameters = array())
    {
        return $this->templatingEngine->render($template, $parameters);
    }

    /**
     * Set allowed, required and default parameters
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    protected function setDefaultParameters(OptionsResolver $resolver)
    {
    }

    /**
     * Set allowed, required and default options
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
    }
}
