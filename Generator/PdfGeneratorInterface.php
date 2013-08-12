<?php

/*
 * This file is part of the OrkestraPdfBundle package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Bundle\PdfBundle\Generator;

/**
 * Defines any contract that a PDF Generator must follow
 */
interface PdfGeneratorInterface
{
    /**
     * Generates a new PDF
     *
     * @param array $parameters
     * @param array $options
     *
     * @return \Orkestra\Bundle\PdfBundle\Pdf\PdfInterface
     */
    public function generate(array $parameters = array(), array $options = array());
}
