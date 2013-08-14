<?php

namespace Orkestra\Bundle\PdfBundle\Pdf\WkPdf;

/**
 * Defines the contract any WkPdfBuilder must implement
 */
interface WkPdfBuilderInterface
{
    const ORIENTATION_PORTRAIT  = 'Portrait';
    const ORIENTATION_LANDSCAPE = 'Landscape';

    const SIZE_A4     = 'A4';
    const SIZE_LETTER = 'Letter';

    /**
     * Set options
     *
     * @param array $options An associative array of options
     *
     * @return void
     */
    public function setOptions(array $options);

    /**
     * Set an option
     *
     * @param string $option The name of the option
     * @param string $value
     *
     * @return void
     */
    public function setOption($option, $value);

    /**
     * Get an option
     *
     * @param string $option
     *
     * @return string
     */
    public function getOption($option);

    /**
     * Render the current configuration
     *
     * @return string
     */
    public function render();

    /**
     * Use a temporary file as output
     *
     * @return void
     */
    public function useTemporaryFile();

    /**
     * Set the file to be written to when rendering
     *
     * @param string $output
     *
     * @return void
     */
    public function setOutput($output);

    /**
     * Set the HTML input to be used to render the PDF
     *
     * @param string $html
     *
     * @return void
     */
    public function setInput($html);

    /**
     * Set the title of the rendered PDF
     *
     * @param string $title
     */
    public function setTitle($title);

    /**
     * The orientation to be used
     *
     * @param string $orientation
     *
     * @return void
     */
    public function setOrientation($orientation);

    /**
     * The page size to be used
     *
     * @param string $size
     *
     * @return void
     */
    public function setPageSize($size);
}
