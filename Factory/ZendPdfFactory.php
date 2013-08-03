<?php

namespace Orkestra\Bundle\PdfBundle\Factory;

use Orkestra\Bundle\PdfBundle\Pdf\ZendPdf;
use ZendPdf\PdfDocument;

class ZendPdfFactory implements PdfFactoryInterface
{
    /**
     * Create a new ZendPdf
     *
     * @param array $options
     *
     * @return \Orkestra\Bundle\PdfBundle\Pdf\PdfInterface|\Orkestra\Bundle\PdfBundle\Pdf\ZendPdf
     */
    public function create(array $options = array())
    {
        return new ZendPdf(new PdfDocument());
    }
}