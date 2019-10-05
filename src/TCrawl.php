<?php

namespace Mfarahani\TelegramChannelCrawl;

class TCrawl
{

    private $httpProxy;
    private $channelName;

    public function __call($name, $arguments)
    {
        if ($name === "setProxy") {
            $this->httpProxy = $arguments[0];
        }

    }

    /**
     * channel function
     *
     * @param string $channelName
     * @return void
     */
    public function setChannel(string $channelName)
    {
        $this->channelName = $channelName;
    }

    public function getInfo()
    {
        $class = new InformationChannel($this->channelName, $this->httpProxy);

        return $class->getInfo();
    }

    public function getLastId()
    {
        $class = new MessageChannel($this->channelName, $this->httpProxy);

        return $class->getLastId();

    }

    public function getLatestMessages(int $fromId = null)
    {
        $class = new MessageChannel($this->channelName, $this->httpProxy);

        return $class->getLatestMessages($fromId);

    }

    public function getLastMessgae()
    {
        $class = new MessageChannel($this->channelName, $this->httpProxy);

        return $class->getLastMessgae();
    }

}
