<?php

/*
 * This file is part of the OrkestraPdfBundle package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Bundle\PdfBundle\Tests\Pdf\WkPdf;

use Orkestra\Bundle\PdfBundle\Pdf\WkPdf\WkPdfBuilder;
use Symfony\Component\Process\ProcessBuilder;

class WkPdfBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBasicFunctionality()
    {
        $processBuilder = new ProcessBuilder();
        $processBuilder->setPrefix('wkhtmltopdf');

        $builder = new WkPdfBuilder($processBuilder);
        $builder->useTemporaryFile();
        $builder->setInput('<strong>This is a test</strong>');

        $process = $builder->getProcess();

        $data = $builder->render();

        // TODO: There must be a better way to assert success...
        $this->assertNotEmpty($data);
        $this->assertStringStartsWith('echo "<strong>This is a test</strong>" | \'wkhtmltopdf\'', $process->getCommandLine());
    }
}
