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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class OrkestraPdfExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->configureTcpdf($container, $config['tcpdf']);
        $this->configureWkhtmltopdf($container, $config['wkhtmltopdf']);

        $container->setParameter('orkestra.pdf.cache_dir', $config['cache_dir']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    private function configureTcpdf(ContainerBuilder $container, array $config)
    {
        $container->setParameter('orkestra.pdf.tcpdf.root_dir', $config['root_dir']);
        $container->setParameter('orkestra.pdf.tcpdf.fonts_dir', $config['fonts_dir']);
        $container->setParameter('orkestra.pdf.tcpdf.image_dir', $config['image_dir']);
    }

    private function configureWkhtmltopdf(ContainerBuilder $container, array $config)
    {
        $container->setParameter('orkestra.pdf.wkhtmltopdf.binary_path', $config['binary_path']);
    }
}
