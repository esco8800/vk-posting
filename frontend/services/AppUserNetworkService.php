<?php
/**
 * Файл класса AppUserNetworkService
 *
 * @copyright Copyright (c) 2020, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace frontend\services;

use Yii;
use yii\authclient\clients\Facebook;
use yii\authclient\clients\Google;
use yii\authclient\clients\VKontakte;
use yii\authclient\OAuth2;
use yii\authclient\OAuthToken;
use yii\web\BadRequestHttpException;

class AppUserNetworkService
{
    /**
     * Получить пользовательские данные
     *
     * @param string $token
     * @param string $client
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function getUserData($token, $client)
    {
        $methodName = 'getUserDataBy' . ucfirst($client);
        if (method_exists($this, $methodName)) {
            return $this->{$methodName}($token, $client);
        }

        throw new BadRequestHttpException("Авторизация через клиент {$client} не реализована.");
    }

    /**
     * Получить данные пользователя по Facebook токену
     *
     * @param string $token
     * @param string $client
     * @return array
     * @throws BadRequestHttpException
     */
    public function getUserDataByFacebook($token, $client)
    {
        try {
            /**@var Facebook $client */
            $client = $this->getAuthClient($token, $client);
            $attributes = $client->getUserAttributes();

            $data = [];
            $data['external_id'] = $attributes['id'];
            $data['name'] = $attributes['first_name'] . ' ' . $attributes['last_name'];
            $data['network'] = $client->getId();

            return $data;
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * Получить данные пользователя по Google токену
     *
     * @param string $token
     * @param string $client
     * @return array
     * @throws BadRequestHttpException
     */
    public function getUserDataByGoogle($token, $client)
    {
        try {
            /**@var Google $client */
            $client = $this->getAuthClient($token, $client);
            $attributes = $client->getUserAttributes();

            $data = [];
            $data['external_id'] = $attributes['id'];
            $data['name'] = $attributes['name'];
            $data['network'] = $client->getId();

            return $data;
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * Получить данные пользователя по Vk токену
     *
     * @param string $token
     * @param string $client
     * @return array
     * @throws BadRequestHttpException
     */
    public function getUserDataByVkontakte($token, $client)
    {
        try {
            /**@var VKontakte $client */
            $client = $this->getAuthClient($token, $client);
            $attributes = $client->getUserAttributes();

            $data = [];
            $data['external_id'] = $attributes['id'];
            $data['name'] = $attributes['first_name'] . ' ' . $attributes['last_name'];
            $data['network'] = $client->getId();

            return $data;
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * Получить авторизованного клиента
     *
     * @param string $token
     * @param string $clientName
     * @return string|OAuth2
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function getAuthClient($token, $clientName)
    {
        /**@var OAuth2 $client */
        $client = $this->getClient($clientName);
        $this->authClient($client, $token);
        return $client;
    }

    /**
     * Получить клиента
     *
     * @param $clientName
     * @return null|OAuth2
     * @throws \yii\base\InvalidConfigException
     */
    public function getClient($clientName)
    {
        /**@var OAuth2 $client */
        return Yii::$app->get('authClientCollection')->getClient($clientName);
    }

    /**
     * @param OAuth2 $client
     * @param $token
     * @throws \yii\web\HttpException]
     */
    public function authClient(OAuth2 $client, $token) {

        if ($client->getName() != 'facebook') {
            $client->fetchAccessToken($token);
        } else {
            $oAuthToken = new OAuthToken();
            $oAuthToken->setToken($token);
            $client->setAccessToken($oAuthToken);
        }
    }

    /**
     * @param array $params
     * @return string
     */
    public function buildFrontendRedirectUrl($params = [])
    {
        $queryParams = $params ?
            '?' . http_build_query($params) :
            '';

        return trim(Yii::$app->params['frontendUrl'], '\/') .
            DIRECTORY_SEPARATOR .
            $queryParams;
    }
}
