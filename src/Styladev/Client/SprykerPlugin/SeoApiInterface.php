<?php

namespace Styladev\Client\SprykerPlugin;

interface SeoApiInterface
{
    /**
     * @param string $key
     *
     * @return Object
     */
    public function getSeoData(string $key): Object;
}
