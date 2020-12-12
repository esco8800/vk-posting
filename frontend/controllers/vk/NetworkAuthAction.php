<?php
/**
 * Файл класса NetworkAction
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace frontend\controllers\vk;

use frontend\controllers\VkController;
use yii\base\Action;
use frontend\services\AppUserNetworkService;
use frontend\models\dto\RequestDTO;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;

class NetworkAuthAction extends Action
{
    /**
     * @var AppUserNetworkService
     */
    protected $service;

    /**
     * Контруктор авторизации
     *
     * @param string $id
     * @param VkController $controller
     * @param AppUserNetworkService $service
     * @param array $config
     */
    public function __construct(
        $id,
        VkController $controller,
        AppUserNetworkService $service,
        array $config = []
    )
    {
        $this->service = $service;
        parent::__construct($id, $controller, $config);
    }

    /**
     * Выполнение действия получения поулчения access_token
     *
     * @return array|void
     * @throws BadRequestHttpException
     * @throws HttpException
     */
    public function run()
    {
        try {
            echo getenv('CLIENT_ID');
            $request = new RequestDTO(\Yii::$app->request);

            if ($request->fromSocials()) {
                $this->redirect($this->service->buildFrontendRedirectUrl([
                    'code' => $request->code,
                    'state' => $request->state
                ]));
            }

            if ($request->fromFrontend()) {
                $client = $this->service->getClient($request->client);
                $this->redirect($client->buildAuthUrl([
                    'state' => $request->state
                ]));
            }
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param $url
     */
    protected function redirect($url)
    {
        \Yii::$app->getResponse()
            ->redirect($url)
            ->send();
    }
}