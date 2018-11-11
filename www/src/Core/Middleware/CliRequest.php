<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Core\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Environment;
use Slim\Http\Request;

/**
 * Class AbstractCommand
 *
 * @package Core\Component
 */
class CliRequest extends Middleware
{
    /**
     * @var ServerRequestInterface
     */
    protected $request = null;

    /**
     * @var ContainerInterface
     */
    public $container;

    /**
     * @var array
     */
    private $properties = [
        'REQUEST_METHOD' => 'GET',
        'REQUEST_URI'    => '',
        'QUERY_STRING'   => '',
        'REMOTE_ADDR'    => 'cli'
    ];

    /**
     * Exposed for testing.
     *
     * @return ServerRequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get a value from an array if exists otherwise return a default value
     *
     * @param   array   $argv
     * @param   integer $key
     * @param   mixed   $default
     *
     * @return  string
     */
    private function get($argv, $key, $default = '')
    {
        if (!array_key_exists($key, $argv)) {
            return $default;
        }

        return $argv[$key];
    }

    /**
     * Construct the URI if path and params are being passed
     *
     * @param string $path
     * @param string $params
     *
     * @return string
     */
    private function getUri($path, $params)
    {
        $uri = '/';
        if (strlen($path) > 0) {
            $uri = $path;
        }

        if (strlen($params) > 0) {
            $uri .= '?' . $params;
        }

        return $uri;
    }

    /**
     * @param string $uri
     * @param string $queryString
     *
     * @return Request
     */
    private function getMockRequest($uri, $queryString)
    {
        $this->properties['REQUEST_URI']  = $uri;
        $this->properties['QUERY_STRING'] = $queryString;

        return Request::createFromEnvironment(Environment::mock($this->properties));
    }

    /**
     * Invoke middleware
     *
     * @param  ServerRequestInterface $request  PSR7 request object
     * @param  ResponseInterface      $response PSR7 response object
     * @param  callable               $next     Next middleware callable
     *
     * @return ResponseInterface PSR7 response object
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        global $argv;

        $this->request = $request;

        if (isset($argv)) {
            $path   = $this->get($argv, 1);
            $params = [];

            for ($i = 2; $i <= count($argv) - 1; $i++) {
                $params[] = $this->get($argv, $i);
            }

            $params = implode("&", $params);

            $this->request = $this->getMockRequest($this->getUri($path, $params), $params);

            unset($argv);
        }

        return $next($this->request, $response);
    }
}