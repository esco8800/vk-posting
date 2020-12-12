<?php

namespace frontend\controllers;

use yii\web\Controller;

/**
 * Site controller
 */
class VkController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'network-auth' => 'frontend\controllers\vk\NetworkAuthAction',
        ];
    }
}
