<?php
/**
 * @company: Bencom (c) 2018.
 * @project: aviasalesBot
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Core\Middleware;

use Interop\Container\ContainerInterface;
use Slim\Exception\NotFoundException;

/**
 * Class Middleware
 *
 * @package Core\Middleware
 */
class Middleware
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Middleware constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function auth()
    {
        return $this->container->get('auth');
    }

    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function user()
    {
        return $this->auth()
                    ->user();
    }

    /**
     * @param $type
     * @param $message
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function flash($type, $message)
    {
        $flash = $this->container->get('flash');
        $flash->addMessage($type, $message);
    }

    /**
     * @param $key
     *
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function config($key)
    {
        $params = $this->container->get('params');

        return $params->get($key);
    }

    /**
     * @param object $response
     * @param        $path
     *
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function redirect($response, $path)
    {
        return $response->withRedirect($this->router()
                                            ->pathFor($path));
    }

    /**
     * @param $request
     * @param $response
     *
     * @throws NotFoundException
     */
    public function notFound($request, $response)
    {
        throw new NotFoundException($request, $response);
    }

    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function router()
    {
        return $this->container->get('router');
    }
}