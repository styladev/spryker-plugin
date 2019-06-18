<?php

namespace Styladev\Yves\SprykerPlugin\Plugin\Provider;

use Silex\Application;
use Spryker\Shared\Config\Config;
use SprykerShop\Yves\ShopApplication\Plugin\Provider\AbstractYvesControllerProvider;
use Styladev\Shared\SprykerPlugin\StylaConstants;

class StylaControllerProvider extends AbstractYvesControllerProvider
{
    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function defineControllers(Application $app)
    {
        $paths = Config::get(StylaConstants::PATHS);
        if ($paths) {
            $this->createController('/{paths}', 'styla-index', 'SprykerPlugin', 'Styla', 'index')
                ->assert('paths', $paths);
        }
    }
}
