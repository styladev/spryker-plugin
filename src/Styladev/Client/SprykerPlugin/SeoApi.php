<?php

namespace Styladev\Client\SprykerPlugin;

use Styladev\Shared\SprykerPlugin\StylaConstants;
use Spryker\Shared\Config\Config;
use stdClass;

class SeoApi implements SeoApiInterface
{
    protected const DEFAULT_SEO_API_URL = 'https://seoapi.styla.com';
    protected const SEO_API_URL_PATTERN = '%s/clients/%s?url=%s';
    protected const STYLA_SEO_API_SUCCESS_CODE = 200;

    /**
     * @param string $key
     *
     * @return Object
     */
    public function getSeoData(string $key): Object
    {
        $seoApiDomain = Config::get(StylaConstants::SEO_API_URL, static::DEFAULT_SEO_API_URL);
        $client = Config::get(StylaConstants::CLIENT);

        $seoApiUrl = sprintf(
            static::SEO_API_URL_PATTERN,
            $seoApiDomain,
            $client,
            preg_replace('#/+#', '/', $key)
        );

        $seoApiJson = $this->fetchFromSeoApi($seoApiUrl);

        if (!$seoApiJson) {
            return new StdClass();
        }

        return $seoApiJson;
    }

    /**
     * @param string $seoApiUrl
     *
     * @return Object|null
     */
    protected function fetchFromSeoApi($seoApiUrl): ?Object
    {
        try {
            $seoContent = @file_get_contents($seoApiUrl);
            if (isset($http_response_header)) {
                if (!in_array('HTTP/1.1 200 OK', $http_response_header) &&
                    !in_array('HTTP/1.0 200 OK', $http_response_header)) {
                    throw new \Exception('Server did not return success header!');
                }
            }

            if ($seoContent) {
                $seoJson = json_decode($seoContent);

                if ($seoJson->status == static::STYLA_SEO_API_SUCCESS_CODE) {
                    return $seoJson;
                }
            }
        } catch (\Exception $e) {
            // Ignore if seo api is not reachable
        }

        return null;
    }
}
