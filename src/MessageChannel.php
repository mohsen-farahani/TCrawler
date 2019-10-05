<?php

namespace Mfarahani\TelegramChannelCrawl;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MessageChannel extends AbstractTCrawl
{

    public function getLastId(): int
    {
        $lastNode = $this->crawler->filter('.force_userpic.js-widget_message')->last();

        return $this->generateId($lastNode);
    }

    public function getLatestMessages(int $fromId = null): Collection
    {
        $result = collect();

        $node = [];
     

        $this->crawler->filter('.force_userpic.js-widget_message')->each(function ($parentCrawler, $i) use ($node , &$result, $fromId) {

            $id = $this->generateId($parentCrawler);

            if ($fromId) {
                if($id > $fromId) {
                    $node['text'] = $parentCrawler->filter('.tgme_widget_message_bubble')->children('.tgme_widget_message_text.js-message_text')->text();
                    $node['id'] = $id;
                }
            } else {
                $node['text'] = $parentCrawler->filter('.tgme_widget_message_bubble')->children('.tgme_widget_message_text.js-message_text')->text();
                $node['id'] = $id;
            }

            $result->push($node);

        });

        return $result->filter()->values();
    }

    public function getLastMessgae()
    {
        $lastNode = $this->crawler->filter('.force_userpic.js-widget_message')->last();

        $message = $lastNode->children('.tgme_widget_message_bubble')->children('.tgme_widget_message_text.js-message_text')->text();

        return $message;

    }

    private function generateId($node)
    {
        return (int) Str::after($node->attr('data-post'), '/');

    }

}
