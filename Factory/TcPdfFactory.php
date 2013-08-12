<?php

/*
 * This file is part of the OrkestraPdfBundle package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Bundle\PdfBundle\Factory;

use Orkestra\Bundle\PdfBundle\Pdf\TcPdf;
use ReflectionClass;

class TcPdfFactory implements PdfFactoryInterface
{
    protected $reflClass;

    public function __construct()
    {
        $this->reflClass = new ReflectionClass('TCPDF');
    }

    /**
     * Create a new TcPdf
     *
     * @param array $options
     *
     * @return \Orkestra\Bundle\PdfBundle\Pdf\PdfInterface|\Orkestra\Bundle\PdfBundle\Pdf\TcPdf
     */
    public function create(array $options = array())
    {
        $pdf = $this->reflClass->newInstanceArgs($this->getConstructorOptions($options));

        foreach ($options as $option => $arguments) {
            if (is_callable(array($pdf, 'set' . $option))) {
                if (!is_array($arguments)) {
                    if (null === $arguments) {
                        $arguments = array();
                    } else {
                        $arguments = array($arguments);
                    }
                }

                call_user_func_array(array($pdf, 'set' . $option), $arguments);
            }
        }

        return new TcPdf($pdf);
    }

    /**
     * Returns an array of constructor arguments
     *
     * This method unsets any constructor arguments in the given options array
     *
     * @param array $options
     *
     * @return array
     */
    protected function getConstructorOptions(array &$options)
    {
        $ctorOptions = array(
            'orientation' => isset($options['orientation']) ? $options['orientation'] : 'P',
            'unit' =>        isset($options['unit']) ?        $options['unit']        : 'mm',
            'format' =>      isset($options['format']) ?      $options['format']      : 'A4',
            'unicode' =>     isset($options['unicode']) ?     $options['unicode']     : true,
            'encoding' =>    isset($options['encoding']) ?    $options['encoding']    : 'UTF-8',
            // Diskcache actually defaults to false, but caching is a good thing, so we will default to true
            'diskcache' =>   isset($options['diskcache']) ?   $options['diskcache']   : true,
            'pdfa' =>        isset($options['pdfa']) ?        $options['pdfa']        : false
        );

        unset(
            $options['orientation'],
            $options['unit'],
            $options['format'],
            $options['unicode'],
            $options['encoding'],
            $options['diskcache'],
            $options['pdfa']
        );

        return array_values($ctorOptions);
    }

    /**
     * The name of this factory
     *
     * @return string
     */
    public function getName()
    {
        return 'tcpdf';
    }
}
