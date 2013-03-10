<?php

namespace Orkestra\Bundle\PdfBundle\Pdf;

/**
 * Wrapper for a PDF generated using wkhtmltopdf
 */
class WkPdf implements PdfInterface
{
    /**
     * @var string
     */
    private $path; // path?

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
