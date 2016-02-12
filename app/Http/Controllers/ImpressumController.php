<?php
namespace App\Http\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ImpressumController
{
    public function render(Request $request, Application $app)
    {
        return $app['twig']->render($this->twigTemplate(), $this->getContext());
    }

    protected function getContext()
    {
        return ['site' => '', 'language_attributes' => '', 'head_title' => ''];
    }

    protected function twigTemplate()
    {
        return 'Impressum.twig';
    }
}
