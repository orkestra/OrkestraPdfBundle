<?php

namespace Orkestra\Bundle\PdfBundle\Factory;

/**
 * Defines the contract a PDF Factory Registry must follow
 */
interface FactoryRegistryInterface
{
    /**
     * Register a PDF factory with this registry
     *
     * @param PdfFactoryInterface $factory
     *
     * @return void
     */
    public function registerFactory(PdfFactoryInterface $factory);

    /**
     * Get a factory by name
     *
     * @param string $name
     *
     * @return PdfFactoryInterface
     */
    public function getFactory($name);
}
