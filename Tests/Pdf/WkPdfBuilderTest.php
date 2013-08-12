<?php

namespace Orkestra\Bundle\PdfBundle\Tests\Generator;

use Orkestra\Bundle\PdfBundle\Factory\WkPdfFactory;
use Orkestra\Bundle\PdfBundle\Pdf\WkPdfBuilder;

class WkPdfBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBasicFunctionality()
    {
        $builder = new WkPdfBuilder('wkhtmltopdf');
        $builder->useTemporaryFile();
        $builder->setInput('<strong>This is a test</strong>');

        $process = $builder->getProcess();
        $pdf     = $builder->getPdf();

        $data = $pdf->getContents();

        // TODO: There must be a better way to assert success...
        $this->assertNotEmpty($data);
        $this->assertStringStartsWith('echo "<strong>This is a test</strong>" | \'wkhtmltopdf\'', $process->getCommandLine());
    }
}
