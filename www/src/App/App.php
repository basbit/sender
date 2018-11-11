<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace App;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App as Slim;

class App extends Slim
{
    /** @var bool */
    public $isConsole = false;

    /**
     * Call middleware stack
     *
     * @param  ServerRequestInterface $request  A request object
     * @param  ResponseInterface      $response A response object
     *
     * @return ResponseInterface
     */
    public function callMiddlewareStack(ServerRequestInterface $request, ResponseInterface $response)
    {
        if (is_null($this->tip)) {
            $this->seedMiddlewareStack();
        }
        /** @var callable $start */
        $start                = $this->tip;
        $this->middlewareLock = true;

        try {
            $response = $start($request, $response);
        } catch (\Exception $ex) {
            $this->errorHandler($ex);
        }

        $this->middlewareLock = false;

        return $response;
    }

    /**
     * @param \Exception $e
     */
    public function errorHandler($e)
    {
        if (ENVIRONMENT == "dev") {
            if (!empty($e->xdebug_message)) {
                if (!$this->isConsole) {
                    echo "<table class='xdebug-error xe-parse-error' dir='ltr' border='1' cellspacing='0' cellpadding='1'>";
                }

                echo $e->xdebug_message;

                if (!$this->isConsole) {
                    echo "</table>";
                }
            } elseif ($e->getMessage()) {
                echo $e->getMessage();
            }
        } else {
            /** @var \Monolog\Logger $logger */
            try {
                $logger = $this->getContainer()
                               ->get('Monolog\Logger');
            } catch (NotFoundExceptionInterface $e) {

                $logger->addCritical($e->getMessage(), (array)$e);
            } catch (ContainerExceptionInterface $e) {

                $logger->addCritical($e->getMessage(), (array)$e);
            }

            $logger->addCritical($e->getMessage(), (array)$e);
        }
    }
}
