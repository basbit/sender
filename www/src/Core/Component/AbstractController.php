<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Core\Component;

use Core\Component\Traits\ControllerTrait;
use Core\Interfaces\ControllerInterface;
use Interop\Container\ContainerInterface;
use Monolog\Logger;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class Controller
 *
 * @package Core\Controller
 */
abstract class AbstractController implements ControllerInterface
{
    /**
     * @var
     */
    protected $request;

    /**
     * @var
     */
    protected $response;

    /**
     * Controller constructor.
     *
     * @param ContainerInterface $container
     * @param Logger             $logger
     */
    public function __construct(
        ContainerInterface $container,
        Logger $logger
    ) {
        $this->logger    = $logger;
        $this->container = $container;
    }

    /**
     * Callable class.
     * Entry point. Call execute method from parent Controller
     *
     * @param Request                $request
     * @param Response               $response
     * @param                        $args route arguments.
     *
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, $args)
    {
        $this->request  = $request;
        $this->response = $response;

        if ($this->request->isGet() && method_exists($this, "get")) {
            $this->get($args);
        } elseif ($this->request->isPost() && method_exists($this, "post")) {
            $this->post($args);
        }

        return $this->execute($args);
    }

    /**
     * @param $property
     *
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __get($property)
    {
        if ($this->container->get($property)) {
            return $this->container->get($property);
        }

        return null;
    }

    /**
     * @param null  $path
     * @param array $args
     * @param array $params
     *
     * @return Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function redirect($path = null, $args = [], $params = [])
    {
        $path = $path != null ? $path : 'index';

        return $this->response->withRedirect($this->router()
                                                  ->pathFor($path, $args, $params));
    }


    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function router()
    {
        $router = $this->container->get("router");

        return $router;
    }
}
