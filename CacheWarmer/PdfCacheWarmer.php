<?php

namespace Orkestra\Bundle\PdfBundle\CacheWarmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PdfCacheWarmer implements CacheWarmerInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * Constructor
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $cacheDir
     *
     * @throws \RuntimeException if the directory cannot be created
     */
    public function warmUp($cacheDir)
    {
        $cacheDir = $this->container->getParameter('orkestra.pdf.cache_dir');

        if (!is_dir($cacheDir)) {
            if (!mkdir($cacheDir, 0777, true)) {
                throw new \RuntimeException(sprintf(
                    'Could not create PDF cache directory "%s"',
                    $cacheDir
                ));
            }
        }
    }

    /**
     * @return bool
     */
    public function isOptional()
    {
        return false;
    }
}
