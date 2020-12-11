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
            'posting' => 'common\modules\user\controllers\api\NetworkAction',
        ];
    }

}