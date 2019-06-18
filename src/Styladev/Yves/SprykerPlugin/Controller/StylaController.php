<?php

namespace Styladev\Yves\SprykerPlugin\Controller;

use Spryker\Shared\Config\Config;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Styladev\Shared\SprykerPlugin\StylaConstants;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Styladev\Client\SprykerPlugin\SprykerPluginClientInterface getClient()
 */
class StylaController extends AbstractController
{
    protected const DEFAULT_INIT_JS_SCRIPT = 'https://engine.styla.com/init.js';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Spryker\Yves\Kernel\View\View
     */
    public function indexAction(Request $request)
    {
        $client = Config::get(StylaConstants::CLIENT);
        $initJsScript = Config::get(StylaConstants::INIT_JS_SCRIPT,
            static::DEFAULT_INIT_JS_SCRIPT);

        $url = parse_url($request->getRequestUri());
        $pathName = ltrim($url['path'], '/');

        $seoJson = $this->getClient()->getSeoData($pathName);
        $seoHead = isset($seoJson->html->head) ? $seoJson->html->head : "";
        $seoBody = isset($seoJson->html->body) ? $seoJson->html->body : "";

        $viewData = [
            'stylaClient'        => $client,
            'stylaInitScriptUrl' => $initJsScript,
            'stylaSeoHead'       => $seoHead,
            'stylaSeoBody'       => $seoBody,
            'stylaUrl'           => $pathName,
        ];

        return $this->view(
            $viewData,
            [],
            '@SprykerPlugin/styla/index.twig'
        );
    }
}
