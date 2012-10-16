<?php

namespace Orkestra\Bundle\PdfBundle\Factory;

use TCPDF;

class TcpdfPdfFactory
{
    /**
     * TODO: Normalize TCPDF into some sort of common class
     *
     * @param array $options
     *
     * @return \TCPDF
     */
    public function create(array $options = array())
    {
        $pdf = new TCPDF();

        foreach ($options as $option => $arguments) {
            if (is_callable(array($pdf, 'set' . $option))) {
                if (!is_array($arguments)) {
                    if (empty($arguments)) {
                        $arguments = array();
                    } else {
                        $arguments = array($arguments);
                    }
                }

                call_user_func_array(array($pdf, 'set' . $option), $arguments);
            }
        }

        return $pdf;
    }
}
