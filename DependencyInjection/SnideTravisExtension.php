<?php

/*
 * This file is part of the SnideTravisBundle bundle.
 *
 * (c) Pascal DENIS <pascal.denis.75@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Snide\Bundle\TravisBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class SnideTravisExtension
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class SnideTravisExtension extends Extension
{
    /**
     * Load configuration of Bundle
     *
     * @param array $configs Configuration parameters
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('collector.xml');
        $loader->load('repository.xml');
        $loader->load('cache.xml');

        $this->loadRepository($loader, $container, $config);
        $this->loadCache($loader, $container, $config);
    }

    /**
     * Load repo
     *
     * @param XmlFileLoader $loader
     * @param ContainerBuilder $container
     * @param array $config
     * @throws \Exception
     */
    protected function loadRepository($loader, ContainerBuilder $container, array $config)
    {
        $container->setParameter('snide_travis.repository.slug', $config['repository']['slug']);
    }

    /**
     * Load cache
     *
     * @param XmlFileLoader $loader
     * @param ContainerBuilder $container
     * @param array $config
     * @throws \Exception
     */
    protected function loadCache($loader, ContainerBuilder $container, array $config)
    {
        if(isset($config['filesystem_cache_path'])) {
            $container->setParameter('snide_travis.cache_path', $config['filesystem_cache_path']);
        }
    }
}
