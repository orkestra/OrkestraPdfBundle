<?php

/*
 * This file is part of the OrkestraPdfBundle package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

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

    /**
     * The name of this factory
     *
     * @return string
     */
    public function getName()
    {
        return 'zendpdf';
    }
}
