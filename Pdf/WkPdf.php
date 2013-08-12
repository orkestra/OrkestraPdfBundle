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

/**
 * Wrapper for a PDF generated using wkhtmltopdf
 *
 * This wrapper is really just a very thin wrapper for a PDF that
 * exists on the filesystem.
 */
class WkPdf implements PdfInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var WkPdfBuilder
     */
    private $builder;

    /**
     * Constructor
     *
     * @param string       $path
     * @param WkPdfBuilder $builder The builder that built this PDF
     */
    public function __construct($path, WkPdfBuilder $builder = null)
    {
        $this->path    = $path;
        $this->builder = $builder;
    }

    /**
     * Gets the contents of the PDF
     *
     * @return string
     */
    public function getContents()
    {
        return file_get_contents($this->path);
    }

    /**
     * Get the underlying PDF object
     *
     * @return WkPdfBuilder|null
     */
    public function getNativeObject()
    {
        return $this->builder;
    }
}
