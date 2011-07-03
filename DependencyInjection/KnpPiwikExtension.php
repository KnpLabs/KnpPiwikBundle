<?php

namespace Knp\Bundle\PiwikBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\FileResource;

/*
 * This file is part of the PiwikBundle.
 * (c) 2011 Knp Labs <http://www.knplabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class KnpPiwikExtension extends Extension
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

        $config = $this->mergeConfigs($configs);

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

    /**
     * Merges the given configurations array
     *
     * @param  array $config
     *
     * @return array
     */
    protected function mergeConfigs(array $configs)
    {
        $merged = array();
        foreach ($configs as $config) {
            $merged = array_merge($merged, $config);
        }

        return $merged;
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
        return 'knp_piwik';
    }
}
