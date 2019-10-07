<?php

namespace Mfarahani\TCrawl\Services\Crawl;

use Symfony\Component\DomCrawler\Crawler;

class InformationChannel
{
    private $crawler;

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * getInfo function
     *
     * @return mixed[]
     */
    public function getInfo(): array
    {
        $this->result = [];

        $this->setTitle();
        $this->setUserName();
        $this->setinfoCounters();
        $this->setDescription();

        return $this->result;
    }

    /**
     * setTitle function
     *
     * @return void
     */
    private function setTitle()
    {
        $this->result["title"] = $this->crawler->filter('.tgme_channel_info_header_title')->text();
    }

    /**
     * setUserName function
     *
     * @return void
     */
    private function setUserName()
    {
        $this->result["username"] = $this->crawler->filter('.tgme_channel_info_header_username')->text();
    }

    /**
     * setinfoCounters function
     *
     * @return void
     */
    private function setinfoCounters()
    {
        $counters = $this->crawler->filter('.tgme_channel_info_counter');

        foreach ($counters as $counter) {
            $txt                = $counter->lastChild->textContent;
            $this->result[$txt] = $counter->firstChild->textContent;
        }

    }

    /**
     * setDescription function
     *
     * @return void
     */
    private function setDescription()
    {
        $this->result["description"] = $this->crawler->filter('.tgme_channel_info_description')->text();
    }
}
