<?php

/*
 * This file is part of the OrkestraPdfBundle package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Bundle\PdfBundle\Tests\Factory;

use Orkestra\Bundle\PdfBundle\Factory\ZendPdfFactory;

class ZendPdfFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $factory = new ZendPdfFactory();

        $pdf = $factory->create();

        $this->assertInstanceOf('ZendPdf\PdfDocument', $pdf->getNativeObject());
    }
}
