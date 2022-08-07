<?php

declare(strict_types=1);

/**
 * This project shows, how you can build a SOLID and restful API with symfony.
 *
 * @copyright  Stefan H.G. Buchhofer
 * @link       www.ilenvo.com
 * @email      ilenvo@me.com
 * @year       2022
 */

namespace App\Services\WebAnalysis\AnalyzeUrl\Version1\Response;

use App\Services\WebAnalysis\AnalyzeUrl\Version1\Request\Request;
use App\Utils\HtmlAnalysis\Manager as HtmlManager;

class ResponseBuilder
{
    public function __construct(
        private readonly Factory $factory,
        private readonly HtmlManager $htmlManager
    ) {
    }

    public function buildResponse(Request $requestModel): Response
    {
        $responseModel = $this->factory->response();
        $responseModel->setUrl($requestModel->getUrl());
        $responseModel->setContentLength($requestModel->getContentLength());
        $responseModel->setDomainName($this->htmlManager->common()->domain()->getDomainName($requestModel->getUrl()));
        $responseModel = $this->addJavascript($requestModel, $responseModel);

        $responseModel = $this->addMetas($requestModel, $responseModel);
        $responseModel = $this->addContent($requestModel, $responseModel);

        return $responseModel;
    }

    private function addMetas(Request $requestModel, Response $responseModel): Response
    {
        $metaModel = $this->factory->meta();
        $metasManager = $this->htmlManager->header()->getMetas();

        $metaModel->setTitle($metasManager->getTitle($requestModel->getRawHtml()));
        $metaModel->setDescription($metasManager->getDescription($requestModel->getRawHtml()));
        $metaModel->setKeywords($metasManager->getKeywords($requestModel->getRawHtml()));
        $metaModel->setEncoding($metasManager->getEncoding($requestModel->getRawHtml()));
        $metaModel->setGenerator($metasManager->getGenerator($requestModel->getRawHtml()));
        $metaModel->setRobots($metasManager->getRobots($requestModel->getRawHtml()));
        $metaModel->setContentLanguage($metasManager->getContentLanguage($requestModel->getRawHtml()));
        $metaModel->setLanguage($metasManager->getLanguage($requestModel->getRawHtml()));

        $responseModel->setMetas($metaModel);

        return $responseModel;
    }

    private function addJavascript(Request $requestModel, Response $responseModel): Response
    {
        $rawHtml = $requestModel->getRawHtml();
        $javascripts = $this->htmlManager->common()->javascript()->getAll($rawHtml);

        foreach ($javascripts[1] ?? [] as $script) {
            $responseModel->addJavascript($this->factory->javascriptItem($script));
        }
        return $responseModel;
    }

    private function addContent(Request $requestModel, Response $responseModel): Response
    {
        $contentModel = $this->factory->content();

        $contentModel->setLinks($this->getLinks($requestModel));
        $contentModel->setHeadlines($this->getHeadlines($requestModel));
        $contentModel->setKeywords($this->getKeywords($requestModel));

        $responseModel->setContent($contentModel);

        return $responseModel;
    }

    private function getLinks(Request $requestModel): Link
    {
        $linksModel = $this->factory->link();
        $domainName = $this->htmlManager->common()->domain()->getDomainName($requestModel->getUrl());
        $rawHtml = $requestModel->getRawHtml();

        // internal links
        $internalLinks = $this->htmlManager->body()->links()->getInternalLinks($rawHtml, $domainName);
        foreach ($internalLinks ?? [] as $internalLink) {
            $linksModel->addInternalLink($this->factory->linkItem($internalLink));
        }

        // external links
        $externalLinks = $this->htmlManager->body()->links()->getExternalLinks($rawHtml, $domainName);
        foreach ($externalLinks ?? [] as $externalLink) {
            $linksModel->addExternalLink($this->factory->linkItem($externalLink));
        }

        return $linksModel;
    }

    private function getHeadlines(Request $requestModel): ?array
    {
        $rawHtml = $requestModel->getRawHtml();
        $headlineModels = [];

        $headlines = $this->htmlManager->body()->headlines()->getHeadlines($rawHtml);

        foreach ($headlines ?? [] as $name => $headline) {
            $headlinesModel = $this->factory->headline();
            $headlinesModel->setName($name);
            $headlinesModel->setCount($headline['count'] ?? 0);
            foreach ($headline['results'] ?? [] as $content) {
                $headlinesModel->addHeadlines($this->factory->headlineItem($content));
            }
            $headlineModels[] = $headlinesModel;
        }

        return $headlineModels;
    }

    private function getKeywords(Request $requestModel): ?array
    {
        $keywords = $this->htmlManager->body()->keywords()->getTopTen($requestModel->getRawHtml());

        $keywordModels = [];
        foreach ($keywords ?? [] as $name => $count) {
            $keywordModel = $this->factory->keyword();
            $keywordModel->setName($name);
            $keywordModel->setCount($count);

            $keywordModels[] = $keywordModel;
        }

        return $keywordModels;
    }
}
