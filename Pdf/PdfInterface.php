<?php

namespace Orkestra\Bundle\PdfBundle\Pdf;

interface PdfInterface
{
    /**
     * Gets the contents of the PDF
     *
     * @return string
     */
    public function getContents();

    /**
     * Get the underlying PDF object
     *
     * @return object
     */
    public function getNativeObject();
}
