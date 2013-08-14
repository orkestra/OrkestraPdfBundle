<?php

/*
 * This file is part of the OrkestraPdfBundle package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Bundle\PdfBundle\Pdf\WkPdf;

use Orkestra\Bundle\PdfBundle\Pdf\WkPdf;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Wrapper for using the wkhtmltopdf binary to generate PDFs
 */
class WkPdfBuilder implements WkPdfBuilderInterface
{
    /**
     * @var ProcessBuilder
     */
    private $processBuilder;

    /**
     * @var array
     */
    private $options = array(
        'title'       => null,
        'orientation' => WkPdfBuilderInterface::ORIENTATION_PORTRAIT,
        'page-size'   => WkPdfBuilderInterface::SIZE_LETTER,
        'output'      => null,
        'input'       => null
    );

    /**
     * @param ProcessBuilder $processBuilder ProcessBuilder instance to be used
     * @param array          $options        Options for PDF rendering
     */
    public function __construct(ProcessBuilder $processBuilder, array $options = array())
    {
        $this->processBuilder = $processBuilder;
        $this->setOptions($options);
    }

    /**
     * Render a PDF with this builder's configuration
     *
     * @return WkPdf
     * @throws \RuntimeException
     */
    public function render()
    {
        $process = $this->getProcess();
        $process->run();
        if (0 === $process->getExitCode()) {
            return file_get_contents($this->getOption('output'));
        }

        throw new \RuntimeException(sprintf('Unable to render PDF. Process exited with "%s" (code: %s)', $process->getExitCodeText(), $process->getExitCode()));
    }

    /**
     * Builds command line arguments based on the current configuration
     *
     * Command line format for wkhtmltopdf:
     * wkhtmltopdf [GLOBAL OPTION]... [OBJECT]... <output file>
     *
     * @return Process
     */
    public function getProcess()
    {
        $args = array(
            '--orientation',
            $this->getOrientation(),
            '--page-size',
            $this->getPageSize(),
            '-',
            $this->getOutput()
        );

        $this->processBuilder->setArguments($args);

        $process = $this->processBuilder->getProcess();

        $process->setCommandLine(sprintf('echo "%s" | %s', addslashes($this->getInput()), $process->getCommandLine()));

        return $process;
    }

    /**
     * Set options on this object in bulk
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        foreach ($options as $option => $value) {
            $this->setOption($option, $value);
        }
    }

    /**
     * Sets the given options
     *
     * @param string $option
     * @param mixed  $value
     *
     * @throws \InvalidArgumentException
     */
    public function setOption($option, $value)
    {
        if (!array_key_exists($option, $this->options)) {
            throw new \InvalidArgumentException(sprintf('Unknown option "%s"', $option));
        }

        $this->options[$option] = $value;
    }

    /**
     * Gets the given option
     *
     * @param string $option
     *
     * @return mixed
     */
    public function getOption($option)
    {
        return isset($this->options[$option])
            ? $this->options[$option]
            : null;
    }

    /**
     * @param string $orientation
     */
    public function setOrientation($orientation)
    {
        $this->setOption('orientation', $orientation);
    }

    /**
     * @return string
     */
    public function getOrientation()
    {
        return $this->getOption('orientation');
    }

    /**
     * @param string $output
     */
    public function setOutput($output)
    {
        $this->setOption('output', $output);
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        return $this->getOption('output');
    }

    /**
     * @param string $size
     */
    public function setPageSize($size)
    {
        $this->setOption('page-size', $size);
    }

    /**
     * @return string
     */
    public function getPageSize()
    {
        return $this->getOption('page-size');
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->setOption('title', $title);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->getOption('title');
    }

    /**
     * Sets the HTML input
     *
     * @param string
     */
    public function setInput($html)
    {
        $this->setOption('input', $html);
    }

    /**
     * Gets the HTML input
     *
     * @return string
     */
    public function getInput()
    {
        return $this->getOption('input');
    }

    /**
     * Sets the output file to a temporary file
     */
    public function useTemporaryFile()
    {
        $this->setOutput(tempnam(sys_get_temp_dir(), 'orkestra_pdf-'));
    }
}
