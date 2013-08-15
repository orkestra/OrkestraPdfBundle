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
            ->scalarNode('cache_dir')->defaultValue('%kernel.cache_dir%/orkestra_pdf')->end()
            ->arrayNode('tcpdf')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('root_dir')->defaultValue('%kernel.root_dir%/../vendor/tecnick.com/tcpdf')->end()
                    ->scalarNode('fonts_dir')->defaultValue('%orkestra.pdf.tcpdf.root_dir%/fonts')->end()
                    ->scalarNode('image_dir')->defaultValue('%orkestra.pdf.tcpdf.root_dir%/images')->end()
                ->end()
            ->end()
            ->arrayNode('wkhtmltopdf')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('binary_path')->defaultValue('wkhtmltopdf')->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
