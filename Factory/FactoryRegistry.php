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

/**
 * Defines the contract a PDF Factory Registry must follow
 */
class FactoryRegistry implements FactoryRegistryInterface
{
    /**
     * @var array|PdfFactoryInterface[]
     */
    private $factories = array();

    /**
     * Register a PDF factory with this registry
     *
     * @param PdfFactoryInterface $factory
     *
     * @return void
     */
    public function registerFactory(PdfFactoryInterface $factory)
    {
        $this->factories[$factory->getName()] = $factory;
    }

    /**
     * Get a factory by name
     *
     * @param string $name
     *
     * @throws \RuntimeException
     * @return PdfFactoryInterface
     */
    public function getFactory($name)
    {
        if (!isset($this->factories[$name])) {
            throw new \RuntimeException(sprintf('No factory registered with name "%s"', $name));
        }

        return $this->factories[$name];
    }
}
