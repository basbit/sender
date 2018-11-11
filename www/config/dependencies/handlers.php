<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

try {
    $container->set('notFoundHandler', function () use ($container)
    {
        return function ($request, $response) use ($container)
        {
            $response = $response->withStatus(404);

            return $container->view->render($response, 'errors/404.phtml', [
                'request_uri' => urldecode($_SERVER['REQUEST_URI'])
            ]);
        };
    });

    $container->set('notAllowedHandler', function () use ($container)
    {
        return function ($request, $response, $methods) use ($container)
        {
            $response = $response->withStatus(405);

            return $container->view->render($response, 'errors/405.phtml', [
                'request_uri' => $_SERVER['REQUEST_URI'],
                'method'      => $_SERVER['REQUEST_METHOD'],
                'methods'     => implode(', ', $methods)
            ]);
        };
    });

    $container->set('errorHandler', function () use ($container)
    {
        return function ($request, $response, $exception) use ($container)
        {
            $response = $response->withStatus(500);

            $data = [
                'exception' => null
            ];

            if (ENVIRONMENT === "dev") {
                $data['exception'] = $exception->getMessage();
            }

            return $container->view->render($response, 'errors/500.phtml', $data);
        };
    });
} catch (\Aura\Di\Exception\ContainerLocked $e) {
    throw $e;
} catch (\Aura\Di\Exception\ServiceNotObject $e) {
    throw $e;
}
