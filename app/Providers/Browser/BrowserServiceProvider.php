<?php
namespace App\Providers\Browser;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class BrowserServiceProvider implements ServiceProviderInterface
{
     /**
     * @inheritdoc
     */
    public function register(Container $container)
    {
        $container['browser'] = function (Container $container) {
            return new Browser;
        };
    }
}
