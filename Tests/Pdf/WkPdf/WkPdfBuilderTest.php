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
use Orkestra\Bundle\PdfBundle\Pdf\WkPdf\WkPdfBuilderInterface;
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
        $builder->setOption('collate', true);
        $builder->setOption('footer-center', 'Some footer');
        $builder->setOption('toc', true);
        $builder->setOrientation(WkPdfBuilderInterface::ORIENTATION_LANDSCAPE);

        $commandLine = $builder->getProcess()->getCommandLine();

        $this->assertStringStartsWith('echo "<strong>This is a test</strong>" | \'wkhtmltopdf\'', $commandLine);
        $this->assertContains(sprintf("'--page-size' '%s'", WkPdfBuilderInterface::SIZE_LETTER), $commandLine, 'Page size defaults to LETTER');
        $this->assertContains(sprintf("'--orientation' '%s'", WkPdfBuilderInterface::ORIENTATION_LANDSCAPE), $commandLine);
        $this->assertContains('--collate', $commandLine);
        $this->assertContains("'toc'", $commandLine);
        $this->assertContains(sprintf("'--footer-center' '%s'", 'Some footer'), $commandLine);
    }
}
