<?php

/*
 * This file is part of the OrkestraPdfBundle package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Bundle\PdfBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OrkestraPdfBundle extends Bundle
{
    /**
     * Boots the bundle
     */
    public function boot()
    {
        $this->initializeTcpdf();
    }

    /**
     * Replicates the tcpdf_config.php file
     */
    private function initializeTcpdf()
    {
        if (defined('K_TCPDF_EXTERNAL_CONFIG')) {
            return;
        }

        define('K_TCPDF_EXTERNAL_CONFIG', true);

        /**
         * Installation path (/var/www/tcpdf/).
         */
        define('K_PATH_MAIN', $this->ensurePathEndsWithSlash($this->container->getParameter('orkestra.pdf.tcpdf.root_dir')));

        /**
         * URL path to tcpdf installation folder (http://localhost/tcpdf/).
         *
         * TODO: This should probably be some public path
         */
        define('K_PATH_URL', $this->ensurePathEndsWithSlash($this->container->getParameter('orkestra.pdf.tcpdf.root_dir')));

        /**
         * path for PDF fonts
         * use K_PATH_MAIN.'fonts/old/' for old non-UTF8 fonts
         */
        define('K_PATH_FONTS', $this->ensurePathEndsWithSlash($this->container->getParameter('orkestra.pdf.tcpdf.fonts_dir')));
        /**
         * cache directory for temporary files (full path)
         */
        define('K_PATH_CACHE', $this->ensurePathEndsWithSlash($this->container->getParameter('orkestra.pdf.cache_dir')));

        /**
         * cache directory for temporary files (url path)
         */
        define('K_PATH_URL_CACHE', $this->ensurePathEndsWithSlash($this->container->getParameter('orkestra.pdf.cache_dir')));

        /**
         *images directory
         */
        define('K_PATH_IMAGES', $this->ensurePathEndsWithSlash($this->container->getParameter('orkestra.pdf.tcpdf.image_dir')));

        /**
         * blank image
         */
        define('K_BLANK_IMAGE', K_PATH_IMAGES.'_blank.png');

        /**
         * height of cell respect font height
         */
        define('K_CELL_HEIGHT_RATIO', 1.25);

        /**
         * reduction factor for small font
         */
        define('K_SMALL_RATIO', 2/3);

        /**
         * set to true to enable the special procedure used to avoid the overlappind of symbols on Thai language
         */
        define('K_THAI_TOPCHARS', true);

        /**
         * if true allows to call TCPDF methods using HTML syntax
         * IMPORTANT: For security reason, disable this feature if you are printing user HTML content.
         */
        define('K_TCPDF_CALLS_IN_HTML', false);
    }

    /**
     * Returns the given path, ensuring it ends with a trailing slash
     *
     * @param string $path
     *
     * @return string
     */
    private function ensurePathEndsWithSlash($path)
    {
        return rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }
}
