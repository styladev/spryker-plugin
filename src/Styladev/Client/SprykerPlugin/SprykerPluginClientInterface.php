<?php

namespace Styladev\Client\SprykerPlugin;

interface SprykerPluginClientInterface
{
    /**
     * @api
     *
     * @param string $key
     *
     * @return Object
     */
    public function getSeoData(string $key): Object;
}
