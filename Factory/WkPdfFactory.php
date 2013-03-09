<?php

namespace Orkestra\Bundle\PdfBundle\Factory;

use Orkestra\Bundle\PdfBundle\Pdf\WkPdf;
use TCPDF;
use ReflectionClass;

class WkPdfFactory implements PdfFactoryInterface
{
    /**
     * Creates a new WkPdf
     *
     * @param array $options
     *
     * @return \Orkestra\Bundle\PdfBundle\Pdf\PdfInterface|\Orkestra\Bundle\PdfBundle\Pdf\WkPdf
     */
    public function create(array $options = array())
    {
        return new WkPdf();
    }
}
