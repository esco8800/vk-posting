<?php
/**
 * Файл класса RequestDTO
 *
 * @copyright Copyright (c) 2020, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace frontend\models\dto;

use yii\web\Request;

class RequestDTO
{
    /**
     * @var string
     */
    public $client;
    /**
     * @var string
     */
    public $code;
    /**
     * @var string
     */
    public $state;

    /**
     * RequestDTO constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->client = $request->get('client', 'vkontakte');
        $this->code = $request->get('code');
        $this->state = $request->get('state');
    }

    /**
     * @return bool
     */
    public function fromSocials()
    {
        return !empty($this->code) && !empty($this->state);
    }

    /**
     * @return bool
     */
    public function fromFrontend()
    {
        return !empty($this->client) && !empty($this->state);
    }


}