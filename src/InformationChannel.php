<?php

namespace Mfarahani\TelegramChannelCrawl;


class InformationChannel extends AbstractTCrawl
{


    /**
     * getInfo function
     *
     * @return object
     */
    public function getInfo(): object
    {
        $this->setTitle();
        $this->setUserName();
        $this->setinfoCounters();
        $this->setDescription();

        
        return $this->result;
    }


    private function setTitle()
    {
        $this->result->title = $this->crawler->filter('.tgme_channel_info_header_title')->text();
    }

    private function setUserName()
    {
        $this->result->userName = $this->crawler->filter('.tgme_channel_info_header_username')->text();
    }

    private function setinfoCounters()
    {
        $counters = $this->crawler->filter('.tgme_channel_info_counter');

        foreach ($counters as $counter) {
            $txt = $counter->lastChild->textContent;
            $this->result->$txt = $counter->firstChild->textContent;
        }

    }

    private function setDescription()
    {
        $this->result->description = $this->crawler->filter('.tgme_channel_info_description')->text();

        return $this->result;
    }
}
