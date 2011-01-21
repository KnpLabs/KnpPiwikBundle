<?php

namespace Bundle\Knplabs\PiwikBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

use Bundle\Knplabs\PiwikBundle\DependencyInjection\PiwikExtension;

/*
 * This file is part of the PiwikBundle.
 * (c) 2011 knpLabs <http://www.knplabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class PiwikExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $container;
    private $extension;

    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new PiwikExtension();
    }

    public function tearDown()
    {
        unset($this->container, $this->extension);
    }

    public function testConfigLoad()
    {
        $this->extension->configLoad(array(), $this->container);

        $this->assertEquals('Knplabs\PiwikClient\Client', $this->container->getParameter('piwik.client.class'));
        $this->assertEquals('piwik.connection.http', $this->container->getParameter('piwik.client.connection.service'));
        $this->assertNull($this->container->getParameter('piwik.client.token'));
        $definition = $this->container->getDefinition('piwik.client');
        $this->assertEquals('%piwik.client.class%', $definition->getClass());
        $this->assertEquals(2, count($args = $definition->getArguments()));
        $this->assertEquals(new Reference('%piwik.client.connection.service%'), $args[0]);
        $this->assertEquals('%piwik.client.token%', $args[1]);

        $this->assertEquals(
            'Knplabs\PiwikClient\Connection\HttpConnection',
            $this->container->getParameter('piwik.connection.http.class')
        );
        $this->assertNull($this->container->getParameter('piwik.connection.http.url'));
        $definition = $this->container->getDefinition('piwik.connection.http');
        $this->assertEquals('%piwik.connection.http.class%', $definition->getClass());
        $this->assertEquals(1, count($args = $definition->getArguments()));
        $this->assertEquals('%piwik.connection.http.url%', $args[0]);

        $this->assertEquals(
            'Knplabs\PiwikClient\Connection\PiwikConnection',
            $this->container->getParameter('piwik.connection.piwik.class')
        );
        $this->assertFalse($this->container->getParameter('piwik.connection.piwik.init'));
        $definition = $this->container->getDefinition('piwik.connection.piwik');
        $this->assertEquals('%piwik.connection.piwik.class%', $definition->getClass());
        $this->assertEquals(1, count($args = $definition->getArguments()));
        $this->assertEquals('%piwik.connection.piwik.init%', $args[0]);
    }

    public function testHttpConfigLoad()
    {
        $this->extension->configLoad(array(
            'connection'    => 'piwik.connection.http',
            'url'           => 'http://example.com',
            'token'         => 'some_token'
        ), $this->container);

        $this->assertEquals('piwik.connection.http', $this->container->getParameter('piwik.client.connection.service'));
        $this->assertEquals('http://example.com', $this->container->getParameter('piwik.connection.http.url'));
        $this->assertEquals('some_token', $this->container->getParameter('piwik.client.token'));
    }

    public function testPiwikConfigLoad()
    {
        $this->extension->configLoad(array(
            'connection'    => 'piwik.connection.piwik',
            'token'         => 'some_token',
            'init'          => true
        ), $this->container);

        $this->assertEquals('piwik.connection.piwik', $this->container->getParameter('piwik.client.connection.service'));
        $this->assertEquals('some_token', $this->container->getParameter('piwik.client.token'));
        $this->assertTrue($this->container->getParameter('piwik.connection.piwik.init'));
    }
}
