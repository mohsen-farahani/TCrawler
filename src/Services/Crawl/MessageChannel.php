<?php

namespace Mfarahani\TCrawl\Services\Crawl;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Mfarahani\TCrawl\Services\TemplateBuilder\TemplateBuilderService;
use Symfony\Component\DomCrawler\Crawler;

class MessageChannel
{

    /** @var DomCrawler/Crawler $crawler */
    private $crawler;

    /**
     * __construct function
     *
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * getLastId function
     *
     * @return integer
     */
    public function getLastId(): int
    {
        $lastNode = $this->crawler->filter('.force_userpic.js-widget_message')->last();

        return $this->generateId($lastNode);
    }

    /**
     * getLatestMessages function
     *
     * @param boolean $formWithTemplate
     * @param string $channelName
     * @param integer $fromId
     * @return Collection
     */
    public function getLatestMessages(bool $formWithTemplate = false, string $channelName, int $fromId = null): Collection
    {
        $result = collect();

        $node = [];

        $this->crawler->filter('.force_userpic.js-widget_message')->each(function ($parentCrawler, $i) use ($node, &$result, $fromId, $formWithTemplate, $channelName) {

            $id = $this->generateId($parentCrawler);

            if ($fromId) {
                if ($id > $fromId) {
                    try {

                        $message     = $parentCrawler->filter('.tgme_widget_message_bubble')->children('.tgme_widget_message_text.js-message_text')->text();
                        $htmlMessage = $parentCrawler->filter('.tgme_widget_message_bubble')->children('.tgme_widget_message_text.js-message_text')->html();
                        if ($formWithTemplate === true) {
                            $templateBuilderService = new TemplateBuilderService();
                            $message                = $templateBuilderService->build($channelName, $message);
                        }

                        $node['text']     = $message;
                        $node['html']     = $htmlMessage;
                        $node['id']       = $id;
                        $node['datetime'] = new \DateTime($parentCrawler->filter('time')->attr('datetime'));

                    } catch (\Throwable $e) {
                        // do nothing... php will ignore and continue
                    }

                }
            } else {
                try {

                    $message     = $parentCrawler->filter('.tgme_widget_message_bubble')->children('.tgme_widget_message_text.js-message_text')->text();
                    $htmlMessage = $parentCrawler->filter('.tgme_widget_message_bubble')->children('.tgme_widget_message_text.js-message_text')->html();
                    if ($formWithTemplate === true) {
                        $templateBuilderService = new TemplateBuilderService();
                        $message                = $templateBuilderService->build($channelName, $message);
                    }

                    $node['text']     = $message;
                    $node['html']     = $htmlMessage;
                    $node['id']       = $id;
                    $node['datetime'] = new \DateTime($parentCrawler->filter('time')->attr('datetime'));

                } catch (\Throwable $e) {
                    // do nothing... php will ignore and continue
                }
            }

            $result->push($node);

        });

        return $result->filter()->values();
    }

    /**
     * getLastMessage function
     *
     * @param boolean $formWithTemplate
     * @param string $channelName
     * @return mixed[]
     */
    public function getLastMessage(bool $formWithTemplate = false, string $channelName): array
    {

        $lastNode = $this->crawler->filter('.force_userpic.js-widget_message')->last();

        $message     = $lastNode->children('.tgme_widget_message_bubble')->children('.tgme_widget_message_text.js-message_text')->text();
        $htmlMessage = $lastNode->children('.tgme_widget_message_bubble')->children('.tgme_widget_message_text.js-message_text')->html();

        $result = [
            "message"     => $message,
            "htmlMessage" => $htmlMessage,
        ];

        if ($formWithTemplate === true) {
            $templateBuilderService = new TemplateBuilderService();
            $message                = $templateBuilderService->build($channelName, $message);

            $result = [
                "message"     => $message,
                "htmlMessage" => $htmlMessage,
            ];
        }

        return $result;

    }

    /**
     * generateId function
     *
     * @param [type] $node
     * @return int
     */
    private function generateId($node): int
    {
        return (int) Str::after($node->attr('data-post'), '/');

    }

}
