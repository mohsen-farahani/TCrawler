<?php

declare (strict_types = 1);

namespace Mfarahani\TCrawl;

use Illuminate\Support\Str;
use Mfarahani\TCrawl\Services\Crawl\CrwalerService;
use Mfarahani\TCrawl\Services\TemplateBuilder\TemplateBuilderService;

class TCrawler
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
     * @return TCrawler
     */
    public function setChannel(string $channelName)
    {
        $this->channelName = Str::after($channelName, "@");

        return $this;
    }

    /**
     * crawler function
     *
     * @return CrwalerService
     */
    public function crawler(): CrwalerService
    {
        return new CrwalerService($this->channelName, $this->httpProxy);
    }

    /**
     * templateBuilder function
     *
     * @return TemplateBuilderService
     */
    public function templateBuilder(): TemplateBuilderService
    {
        return new TemplateBuilderService;
    }

}
