<?php

/*
 * This file is part of the OrkestraPdfBundle package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Bundle\PdfBundle\Tests\Factory;

use Orkestra\Bundle\PdfBundle\Factory\FactoryRegistry;
use Orkestra\Bundle\PdfBundle\Factory\PdfFactoryInterface;

class FactoryRegistryTest extends \PHPUnit_Framework_TestCase
{
    public function testFunctionality()
    {
        $factory = new TestFactory();

        $registry = new FactoryRegistry();
        $registry->registerFactory($factory);

        $this->assertSame($factory, $registry->getFactory('registry_test'));
    }
}

class TestFactory implements PdfFactoryInterface
{
    public function create(array $options = array())
    {
        return 'fake';
    }

    public function getName()
    {
        return 'registry_test';
    }
}
