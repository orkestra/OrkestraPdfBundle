<?php

namespace Orkestra\Bundle\PdfBundle\Factory;

interface PdfFactoryInterface
{
    /**
     * Creates a new PDF
     *
     * @param array $options
     *
     * @return \TCPDF
     */
    function create(array $options = array());
}
