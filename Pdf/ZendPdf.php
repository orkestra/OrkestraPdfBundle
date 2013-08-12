<?php

/*
 * This file is part of the OrkestraPdfBundle package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Bundle\PdfBundle\Pdf;

use ZendPdf\PdfDocument;

/**
 * Wrapper for a Zend PDF PdfDocument
 */
class ZendPdf implements PdfInterface
{
    /**
     * @var \ZendPdf\PdfDocument
     */
    private $zendPdf;

    /**
     * Constructor
     *
     * @param \ZendPdf\PdfDocument $zendPdf
     */
    public function __construct(PdfDocument $zendPdf)
    {
        $this->zendPdf = $zendPdf;
    }

    /**
     * Gets the contents of the PDF
     *
     * @return string
     */
    public function getContents()
    {
        return $this->zendPdf->render();
    }

    /**
     * Get the underlying PDF object
     *
     * @return object
     */
    public function getNativeObject()
    {
        return $this->zendPdf;
    }
}
