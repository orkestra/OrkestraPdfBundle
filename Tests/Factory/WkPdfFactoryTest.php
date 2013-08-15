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

use Orkestra\Bundle\PdfBundle\Factory\WkPdfFactory;

class WkPdfFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $factory = new WkPdfFactory('/path/to/wkhtmltopdf');

        $pdf = $factory->create(array(
            'some-option' => 'value'
        ));

        $this->assertInstanceOf('Orkestra\Bundle\PdfBundle\Pdf\WkPdf\WkPdfBuilderInterface', $pdf->getNativeObject());
        $this->assertContains('/path/to/wkhtmltopdf', $pdf->getNativeObject()->getProcess()->getCommandLine());
        $this->assertEquals('value', $pdf->getNativeObject()->getOption('some-option'));
    }
}
