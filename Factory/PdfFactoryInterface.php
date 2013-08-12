<?php

namespace Orkestra\Bundle\PdfBundle\Factory;

interface PdfFactoryInterface
{
    /**
     * Creates a new PDF
     *
     * @param array $options
     *
     * @return \Orkestra\Bundle\PdfBundle\Pdf\PdfInterface
     */
    public function create(array $options = array());

    /**
     * The name of this factory
     *
     * This name should be unique.
     *
     * @return string
     */
    public function getName();
}
