<?php
namespace App\Providers\Whoops;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Silex\Api\EventListenerProviderInterface;
use Silex\ExceptionListenerWrapper;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsServiceProvider implements ServiceProviderInterface, EventListenerProviderInterface
{
    public function register(Container $container)
    {
        $this->registerErrorPageHandler($container);
        $this->registerExceptionHandler($container);
        $this->registerWhoops($container);

        if (set_exception_handler($container['whoops.exception_handler']) !== null) {
            restore_exception_handler();
        }

        $container['whoops']->pushHandler(new RequestHandler($container));

        if ($container instanceof Application) {
            $container['whoops']->pushHandler(new SilexApplicationHandler($container));
        }

        $container['whoops']->register();
    }

    public function subscribe(Container $container, EventDispatcherInterface $dispatcher)
    {
        if ($container instanceof Application) {
            $dispatcher->addListener(
                KernelEvents::EXCEPTION,
                new ExceptionListenerWrapper($container, $container['whoops.exception_handler']),
                -1
            );
        }
    }

    private function registerWhoops(Container $container)
    {
        $container['whoops'] = function (Container $container) {
            $run = new Run;
            $run->allowQuit(false);
            $run->pushHandler($container['whoops.error_page_handler']);
            return $run;
        };
    }

    private function registerErrorPageHandler(Container $container)
    {
        $container['whoops.error_page_handler'] = function () {
            if (PHP_SAPI === 'cli') {
                return new PlainTextHandler;
            } else {
                return new PrettyPageHandler;
            }
        };
    }

    private function registerExceptionHandler(Container $container)
    {
        $container['whoops.exception_handler'] = $container->protect(function ($e) use ($container) {
            $method = Run::EXCEPTION_HANDLER;
            ob_start();

            $container['whoops']->$method($e);
            $response = ob_get_clean();
            $code = $e instanceof HttpException ? $e->getStatusCode() : 500;

            return new Response($response, $code);
        });
    }
}
