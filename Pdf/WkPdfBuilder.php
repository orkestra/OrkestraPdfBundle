<?php

/*
 * This file is part of the OrkestraPdfBundle package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Bundle\PdfBundle\Pdf;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Wrapper for a PDF generated using wkhtmltopdf
 */
class WkPdfBuilder implements PdfInterface
{
    const ORIENTATION_PORTRAIT  = 'Portrait';

    const ORIENTATION_LANDSCAPE = 'Landscape';

    const SIZE_A4 = 'A4';

    const SIZE_LETTER = 'Letter';

    /**
     * @var string
     */
    private $executable;

    /**
     * @var WkPdf
     */
    private $pdf;

    /**
     * @var bool
     */
    private $dirty = false;

    /**
     * @var array
     */
    private $options = array(
        'title'       => null,
        'orientation' => self::ORIENTATION_PORTRAIT,
        'size'        => self::SIZE_LETTER,
        'toc'         => false,
        'uri'         => null,
        'output'      => null,
        'input'       => null
    );

    /**
     * @param string $executable Path to wkhtmltopdf binary
     * @param array  $options    Options for PDF rendering
     */
    public function __construct($executable, array $options = array())
    {
        $this->executable = $executable;
        $this->setOptions($options);
    }

    /**
     * Render a PDF with this builder's configuration
     *
     * @return WkPdf
     * @throws \RuntimeException
     */
    private function render()
    {
        $process = $this->getProcess();
        $process->run();
        if (0 === $process->getExitCode()) {
            return new WkPdf($this->getOption('output'), $this);
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
        $builder = new ProcessBuilder();
        $args = array(
            '--orientation',
            $this->getOrientation(),
            '--page-size',
            $this->getSize(),
            '-',
            $this->getOutput()
        );

        $builder->setPrefix($this->executable);
        $builder->setArguments($args);

        $process = $builder->getProcess();

        $process->setCommandLine(sprintf('echo "%s" | %s', addslashes($this->getInput()), $process->getCommandLine()));

        return $process;
    }

    /**
     * Renders the PDF and returns it
     *
     * @return WkPdf
     */
    public function getPdf()
    {
        if ($this->dirty) {
            $this->pdf = $this->render();
        }

        return $this->pdf;
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
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    public function setOption($option, $value)
    {
        if (!array_key_exists($option, $this->options)) {
            throw new \InvalidArgumentException(sprintf('Unknown option "%s"', $option));
        }

        $this->options[$option] = $value;
        $this->dirty = true;
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
     * @param string $executable
     */
    public function setExecutable($executable)
    {
        $this->executable = $executable;
    }

    /**
     * @return string
     */
    public function getExecutable()
    {
        return $this->executable;
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
    public function setSize($size)
    {
        $this->setOption('size', $size);
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->getOption('size');
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
     * @param boolean $toc
     */
    public function setToc($toc)
    {
        $this->setOption('toc', $toc);
    }

    /**
     * @return boolean
     */
    public function getToc()
    {
        return $this->getOption('toc');
    }

    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->setOption('uri', $uri);
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->getOption('uri');
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

    /**
     * Gets the contents of the PDF
     *
     * @return string
     */
    public function getContents()
    {
        return $this->getPdf()->getContents();
    }

    /**
     * Get the underlying PDF object
     *
     * @return object
     */
    public function getNativeObject()
    {
        return $this;
    }
}
