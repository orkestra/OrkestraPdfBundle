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

use Orkestra\Bundle\PdfBundle\Pdf\WkPdf;
use Orkestra\Bundle\PdfBundle\Pdf\WkPdfBuilder;

class WkPdfFactory implements PdfFactoryInterface
{
    private $executable = 'wkhtmltopdf';

    /**
     * Creates a new WkPdf
     *
     * @param array $options
     *
     * @return \Orkestra\Bundle\PdfBundle\Pdf\PdfInterface|\Orkestra\Bundle\PdfBundle\Pdf\WkPdfBuilder
     */
    public function create(array $options = array())
    {
        return new WkPdfBuilder($this->executable, $options);
    }

    /**
     * The name of this factory
     *
     * @return string
     */
    public function getName()
    {
        return 'wkpdf';
    }
}
