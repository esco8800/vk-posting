<?php

namespace console\controllers\vk;

use common\components\vk\VkComponent;
use yii\base\Action;
use yii\console\ExitCode;
use yii\helpers\Console;

class PostingAction extends  Action
{
    /**
     * @var VkComponent
     */
    private $vkComponent;

    public function __construct(
        $id,
        $controller,
        VkComponent $vkComponent,
        $config = []
    ) {
        $this->vkComponent = $vkComponent;
        parent::__construct($id, $controller, $config);
    }

    /**
     * Автопостинг предложки
     * @return int
     */
    public function run()
    {
        try {
            var_dump($this->vkComponent->getSuggestsPost(135904652));
            $this->controller->stdout("Успешно\n", Console::FG_GREEN);
            return ExitCode::OK;

        } catch (\Exception|\Throwable $e) {
            \Yii::error($e, $e->getMessage());
            $this->controller->stdout("Ошибка\n {$e->getMessage()}", Console::FG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }

}