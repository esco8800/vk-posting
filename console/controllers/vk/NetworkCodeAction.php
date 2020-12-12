<?php
/**
 * Файл класса NetworkAction
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\controllers\api;

use yii\base\Action;
use common\modules\user\controllers\ApiAuthController;
use common\modules\user\services\AppUserNetworkService;
use common\modules\user\services\AppUserService;
use Yii;
use common\modules\user\models\dto\RequestDTO;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;

class NetworkCodeAction extends Action
{
    /**
     * @var AppUserNetworkService
     */
    protected $service;

    /**
     * Контруктор авторизации
     *
     * @param string $id
     * @param ApiAuthController $controller
     * @param AppUserNetworkService $service
     * @param array $config
     */
    public function __construct(
        $id,
        ApiAuthController $controller,
        AppUserNetworkService $service,
        array $config = []
    )
    {
        $this->service = $service;
        parent::__construct($id, $controller, $config);
    }

    /**
     * Выполнение действия получения code от соц сетей
     *
     * @return array|void
     * @throws BadRequestHttpException
     * @throws HttpException
     */
    public function run()
    {
        try {
            $request = new RequestDTO(Yii::$app->request);

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
        Yii::$app->getResponse()
            ->redirect($url)
            ->send();
    }
}
