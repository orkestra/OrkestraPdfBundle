<?php

namespace Orkestra\Bundle\PdfBundle\Pdf;

/**
 * Wrapper for a TCPDF document
 */
class TcPdf implements PdfInterface
{
    /**
     * @var \TCPDF
     */
    private $tcpdf;

    /**
     * Constructor
     *
     * @param \TCPDF $tcpdf
     */
    public function __construct(\TCPDF $tcpdf)
    {
        $this->tcpdf = $tcpdf;
    }

    /**
     * Gets the contents of the PDF
     *
     * @return string
     */
    public function getContents()
    {
        return $this->tcpdf->output('', 'S');
    }

    /**
     * Get the underlying PDF object
     *
     * @return object
     */
    public function getNativeObject()
    {
        return $this->tcpdf;
    }
}
