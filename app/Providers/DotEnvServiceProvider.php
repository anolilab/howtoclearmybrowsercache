<?php
namespace App\Providers;

use Cekurte\Environment\Environment;
use Dotenv\Dotenv;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class DotEnvServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register(Container $container)
    {
        $container['dotenv'] = function (Container $container) {
            $dotenv = new Dotenv(__DIR__.'/../..');

            $dotenv->load();

            // Requiring Variables to be Set
            $dotenv->required('APP_DEBUG');

            $this->addEnvVarsToApp($container);
        };
    }

    /**
     * collect vars and sets them to the DIC
     *
     * @param Container $container
     */
    protected function addEnvVarsToApp(Container $container)
    {
        $envVars = array_merge($_SERVER, $_ENV);

        foreach ($envVars as $envVar => $empty) {
            if ($this->findEnvironmentVariable($envVar)) {
                $container['dotenv.' . strtolower($envVar)] = Environment::get($envVar);
            }
        }
    }

    /**
     * Search the different places for environment variables and return first value found.
     *
     * @param string $name
     *
     * @return string
     */
    protected function findEnvironmentVariable($name)
    {
        switch (true) {
            case array_key_exists($name, $_ENV):
                return true;
            case array_key_exists($name, $_SERVER):
                return true;
            default:
                $value = getenv($name);
                return $value === false ? null : $value; // switch getenv default to null
        }
    }
}
