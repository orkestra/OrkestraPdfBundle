<?php

/*
 * This file is part of the OrkestraPdfBundle package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Bundle\PdfBundle\Factory;

use Orkestra\Bundle\PdfBundle\Pdf\PdfInterface;
use Orkestra\Bundle\PdfBundle\Pdf\WkPdf;
use Orkestra\Bundle\PdfBundle\Pdf\WkPdf\WkPdfBuilder;
use Symfony\Component\Process\ProcessBuilder;

class WkPdfFactory implements PdfFactoryInterface
{
    /**
     * @var string Path to wkhtmltopdf executable
     */
    private $executable = 'wkhtmltopdf';

    /**
     * Constructor
     *
     * @param string $executable Path to wkhtmltopdf executable
     */
    public function __construct($executable = null)
    {
        $this->executable = $executable ?: $this->executable;
    }

    /**
     * Creates a new WkPdf
     *
     * @param array $options
     *
     * @return PdfInterface|WkPdf
     */
    public function create(array $options = array())
    {
        return new WkPdf(new WkPdfBuilder($this->createProcessBuilder(), $options));
    }

    /**
     * @return ProcessBuilder
     */
    private function createProcessBuilder()
    {
        $builder = new ProcessBuilder();
        $builder->setPrefix($this->executable);

        return $builder;
    }

    /**
     * The name of this factory
     *
     * @return string
     */
    public function getName()
    {
        return 'wkpdf';
    }
}
