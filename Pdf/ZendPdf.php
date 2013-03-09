<?php

namespace Orkestra\Bundle\PdfBundle\Pdf;

class ZendPdf implements PdfInterface
{
    /**
     * @var \Zend\Pdf
     */
    private $zendPdf;

    /**
     * Gets the contents of the PDF
     *
     * @return string
     */
    public function getContents()
    {

    }

    /**
     * Get the underlying PDF object
     *
     * @return object
     */
    public function getNativeObject()
    {

    }
}
