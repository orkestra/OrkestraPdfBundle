<?php

namespace Orkestra\Bundle\PdfBundle\Generator;

/**
 * Defines any contract that a PDF Generator must follow
 */
interface PdfGeneratorInterface
{
    /**
     * Generates a new PDF
     *
     * @param array $parameters
     * @param array $options
     *
     * @return \Orkestra\Bundle\PdfBundle\Pdf\PdfInterface
     */
    function generate(array $parameters = array(), array $options = array());
}
