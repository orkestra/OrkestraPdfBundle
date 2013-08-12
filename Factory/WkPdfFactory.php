<?php

namespace Orkestra\Bundle\PdfBundle\Factory;

use Orkestra\Bundle\PdfBundle\Pdf\WkPdf;
use Orkestra\Bundle\PdfBundle\Pdf\WkPdfBuilder;
use Symfony\Component\Finder\Finder;
use TCPDF;
use ReflectionClass;

class WkPdfFactory implements PdfFactoryInterface
{
    private $executable = 'wkhtmltopdf';

    /**
     * Creates a new WkPdf
     *
     * @param array $options
     *
     * @return \Orkestra\Bundle\PdfBundle\Pdf\PdfInterface|\Orkestra\Bundle\PdfBundle\Pdf\WkPdfBuilder
     */
    public function create(array $options = array())
    {
        return new WkPdfBuilder($this->executable, $options);
    }
}
