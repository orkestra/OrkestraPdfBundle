<?php

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
