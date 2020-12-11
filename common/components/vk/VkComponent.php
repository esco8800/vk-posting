<?php

namespace common\components\vk;

use VK\Client\VKApiClient;

class VkComponent
{
    /**
     * @var VKApiClient
     */
    private $client;

    /**
     * VkComponent constructor.
     * @param VKApiClient $client
     */
    public function __construct(VKApiClient $client)
    {
        $this->client = $client;
    }

}