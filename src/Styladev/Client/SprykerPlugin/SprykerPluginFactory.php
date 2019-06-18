<?php

namespace Styladev\Client\SprykerPlugin;

use Spryker\Client\Kernel\AbstractFactory;

class SprykerPluginFactory extends AbstractFactory
{
    /**
     * @return \Styladev\Client\SprykerPlugin\SeoApiInterface
     */
    public function getSeoApi(): SeoApiInterface
    {
        return new SeoApi();
    }

    /**
     * @return \Spryker\Client\Storage\StorageClientInterface
     */
    public function getStorageClient()
    {
        return $this->getProvidedDependency(SprykerPluginDependencyProvider::CLIENT_STORAGE);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore()
    {
        return $this->getProvidedDependency(SprykerPluginDependencyProvider::STORE);
    }
}
