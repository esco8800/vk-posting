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
     * @var string
     */
    private $accessToken;
    /**
     * @var array
     */
    private $groupIds = [
        135904652
    ];

    /**
     * VkComponent constructor.
     * @param VKApiClient $client
     */
    public function __construct(VKApiClient $client)
    {
        $this->client = $client;
        $this->setAccessToken();
    }

    public function postSuggestsPost($groupId)
    {
        $post = $this->getSuggestsPost($groupId);
        $this->client
            ->wall()
            ->post($this->accessToken, [
                'owner_id' => -$groupId,
            ]);
    }

    /**
     * @param string $groupId
     * @return mixed
     * @throws \VK\Exceptions\Api\VKApiBlockedException
     * @throws \VK\Exceptions\VKApiException
     * @throws \VK\Exceptions\VKClientException
     */
    public function getSuggestsPost($groupId)
    {
        return $this->client
            ->wall()
            ->get($this->accessToken, [
                'owner_id' => -$groupId,
                'count' => 1,
                'filter' => 'suggests',
            ]);
    }

    public function setAccessToken()
    {
        $this->accessToken = \Yii::$app->params['accessToken'];
    }

}