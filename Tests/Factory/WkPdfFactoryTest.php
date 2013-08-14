<?php

namespace Orkestra\Bundle\PdfBundle\Tests\Factory;

use Orkestra\Bundle\PdfBundle\Factory\WkPdfFactory;

class WkPdfFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $factory = new WkPdfFactory();

        $pdf = $factory->create();

        $this->assertInstanceOf('Orkestra\Bundle\PdfBundle\Pdf\WkPdf\WkPdfBuilderInterface', $pdf->getNativeObject());
    }
}
