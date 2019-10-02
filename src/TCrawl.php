<?php

namespace Mfarahani\TelegramChannelCrawl;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleHttpClient;

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

    public function lastId()
    {

    }

    public function getLatestMessages()
    {

    }

    public function getLastMessgae()
    {
        
    }

}
