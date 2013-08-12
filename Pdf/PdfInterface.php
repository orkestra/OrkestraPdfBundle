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
