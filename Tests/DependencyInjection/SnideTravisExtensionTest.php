<?php

/*
 * This file is part of the SnideTravisBundle bundle.
 *
 * (c) Pascal DENIS <pascal.denis.75@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Snide\Bundle\TravisBundle\Tests\DependencyInjection;

use Snide\Bundle\TravisBundle\DependencyInjection\SnideTravisExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

/**
 * Class SnideTravisExtensionTest
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class SnideTravisExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var ContainerBuilder */
    protected $configuration;

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadRepositorySlugThrowsExceptionUnless()
    {
        $loader = new SnideTravisExtension();
        $config = $this->getConfig();
        unset($config['repository']['slug']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadRepositoryThrowsExceptionUnlessSet()
    {
        $loader = new SnideTravisExtension();
        $config = $this->getConfig();
        unset($config['repository']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * Test load cache path
     */
    public function testLoadCachePath()
    {
        $this->loadConfiguration();
        $this->assertEquals($this->configuration->getParameter('snide_travis.cache_path'), '/tmp');
    }

    /**
     * Test load cache path
     */
    public function testLoadRepository()
    {
        $this->loadConfiguration();
        $repository = $this->configuration->get('snide_travis.repository');

        $this->assertEquals('pdenis/SnideTravisBundle', $repository->getSlug());
    }

    /**
     * Load bundle configuration
     */
    protected function loadConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new SnideTravisExtension();
        $config = $this->getConfig();
        $loader->load(array($config), $this->configuration);
    }
    /**
     * getConfig
     *
     * @return array
     */
    protected function getConfig()
    {
        $yaml = <<<EOF
repository:
    slug: pdenis/SnideTravisBundle
filesystem_cache_path: /tmp
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }
}