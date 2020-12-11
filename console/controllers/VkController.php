<?php

namespace console\controllers;

use yii\console\Controller;

class VkController extends Controller
{

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'posting' => 'console\controllers\vk\PostingAction',
        ];
    }

}