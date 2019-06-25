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
        $seoHead = isset($seoJson->html->head) ? $this->cleanTitleTag($seoJson->html->head) : "";
        $seoBody = isset($seoJson->html->body) ? $seoJson->html->body : "";
        $seoTitle = $this->getPageTitle($seoJson);

        $viewData = [
            'stylaClient'        => $client,
            'stylaInitScriptUrl' => $initJsScript,
            'stylaSeoHead'       => $seoHead,
            'stylaSeoBody'       => $seoBody,
            'stylaSeoTitle'      => $seoTitle,
            'stylaUrl'           => $pathName,
        ];

        return $this->view(
            $viewData,
            [],
            '@SprykerPlugin/styla/index.twig'
        );
    }

    private function cleanTitleTag($seoHead): string
    {
        return $this->cleanTag($seoHead, "title");
    }

    private function cleanTag($searchString, $tagName): string
    {
        return preg_replace('/<' . $tagName . '.*?>(.*)?<\/' . $tagName . '>/im', '', $searchString);
    }

    private function getPageTitle($seoJson): string
    {
        if (!isset($seoJson->tags)) {
            return null;
        }

        $pageTitle = null;
        foreach($seoJson->tags as $tag) {
            if ($tag->tag == 'title') {
                $pageTitle = $tag->content;
                break;
            }
        }

        return $pageTitle;
    }
}
