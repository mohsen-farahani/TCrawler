<?php

namespace Mfarahani\TelegramChannelCrawl;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleHttpClient;

abstract class AbstractTCrawl
{

    /**@var Goutte\Client */
    protected $client;

    /**@var $crawler */
    protected $crawler;

    /**@var stdClass */
    protected $result;

    private $httpProxy;

    private $channelName;

    const BASEURL = "https://t.me/s/";

    public function __construct(string $channelName , string $httpProxy = null)
    {
        $this->httpProxy = $httpProxy;
        $this->channelName = $channelName;

        $this->connect();
        $this->setChannel($channelName);
    }

    private function connect()
    {

        $this->client = new Client();
        $guzzleClient = new GuzzleHttpClient([
            'proxy' => $this->httpProxy,
        ]);
        $this->client->setClient($guzzleClient);

        $this->result = new \stdClass;
    }

    private function setChannel()
    {
        $url = self::BASEURL . $this->channelName;

        $this->crawler = $this->client->request("GET", $url);

    }

}
