<?php

/*
 * This file is part of the SnideTravisBundle bundle.
 *
 * (c) Pascal DENIS <pascal.denis.75@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Snide\Bundle\TravisBundle\DataCollector;

use Doctrine\Common\Cache\Cache;
use Snide\Travis\Client;
use Snide\Travis\Model\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Guzzle\Http\Message\EntityEnclosingRequest;
use Guzzle\Cache\DoctrineCacheAdapter;
use Guzzle\Plugin\Cache\CachePlugin;
use Guzzle\Plugin\Cache\DefaultCacheStorage;

/**
 * Class TravisDataCollector
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class TravisDataCollector extends DataCollector
{
    /**
     * Client
     *
     * @var \Snide\Travis\Client
     */
    protected $client;

    /**
     * Repository
     *
     * @var \Snide\Travis\Model\Repository
     */
    protected $repository;

    /**
     * Constructor
     */
    public function __construct(Client $client, Repository $repository, Cache $cache)
    {
        $this->client = new Client();
        $this->repository = $repository;

        $this->loadCache($cache);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param \Exception $exception
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        try {
            $this->data = $this->client->fetchRepository(
                $this->repository
            );
        } catch(\Exception $e) {}
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'snide_travis';
    }

    /**
     * Create and load client cache
     *
     * @param Cache $cache
     */
    protected function loadCache(Cache $cache)
    {

        $cachePlugin = new CachePlugin(array(
            'storage' => new DefaultCacheStorage(
                new DoctrineCacheAdapter(
                    $cache
                )
            )
        ));

        $this->client->addSubscriber($cachePlugin);
    }
}