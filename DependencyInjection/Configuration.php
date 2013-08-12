<?php

/*
 * This file is part of the OrkestraPdfBundle package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Bundle\PdfBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('orkestra_pdf');

        $rootNode->children()
            ->scalarNode('root_dir')->defaultValue('%kernel.root_dir%/../vendor/tcpdf/tcpdf')->end()
            ->scalarNode('cache_dir')->defaultValue('%kernel.cache_dir%/orkestra_pdf')->end()
            ->scalarNode('fonts_dir')->defaultValue('%orkestra.pdf.tcpdf.root_dir%/fonts')->end()
            ->scalarNode('image_dir')->defaultValue('%orkestra.pdf.tcpdf.root_dir%/images')->end()
        ->end();

        return $treeBuilder;
    }
}
