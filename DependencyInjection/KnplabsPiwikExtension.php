<?php

namespace Knplabs\Bundle\PiwikBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\FileResource;

/*
 * This file is part of the PiwikBundle.
 * (c) 2011 knpLabs <http://www.knplabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class KnplabsPiwikExtension extends Extension
{
    /**
     * Loads the piwik configuration.
     *
     * @param array $config  An array of configuration settings
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container A ContainerBuilder instance
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (!$container->hasDefinition('piwik.client')) {
            $loader->load('piwik.xml');
        }

        foreach ($configs as $config) {
            if (isset($config['connection'])) {
                $definition     = $container->getDefinition('piwik.client');
                $arguments      = $definition->getArguments();
                $arguments[0]   = new Reference($config['connection']);
                $definition->setArguments($arguments);
            }
            if (isset($config['url'])) {
                $container->setParameter('piwik.connection.http.url', $config['url']);
            }
            if (isset($config['init'])) {
                $container->setParameter('piwik.connection.piwik.init', (bool) $config['init']);
            }
            if (isset($config['token'])) {
                $container->setParameter('piwik.client.token', $config['token']);
            }
        }
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }

    public function getNamespace()
    {
        return 'http://www.knplabs.com/schema/dic/piwik_bundle';
    }

    public function getAlias()
    {
        return 'knplabs_piwik';
    }
}
