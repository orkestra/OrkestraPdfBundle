<?php

namespace Orkestra\Bundle\PdfBundle\Tests\Factory;

use Orkestra\Bundle\PdfBundle\Factory\TcPdfFactory;

class TcPdfFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $factory = new TcPdfFactory();

        $pdf = $factory->create();

        $this->assertInstanceOf('TCPDF', $pdf->getNativeObject());
    }
}
