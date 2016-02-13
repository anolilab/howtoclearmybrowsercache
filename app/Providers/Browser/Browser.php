<?php
namespace App\Providers\Browser;

use Ikimea\Browser\Browser as IkimeaBrowser;

class Browser extends IkimeaBrowser
{
    /**
     * Protected routine to determine the browser type.
     *
     * @return bool True if the browser was detected otherwise false
     */
    protected function checkBrowsers()
    {
        return (
            parent::checkBrowsers()
        );
    }
}
