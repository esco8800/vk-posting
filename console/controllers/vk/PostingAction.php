<?php

namespace console\controllers\vk;

use yii\base\Action;
use yii\console\ExitCode;
use yii\helpers\Console;

class PostingAction extends  Action
{
    /**
     * Автопостинг предложки
     * @return int
     */
    public function run()
    {
        try {

            $this->controller->stdout("Успешно\n", Console::FG_GREEN);
            return ExitCode::OK;

        } catch (\Exception|\Throwable $e) {
            \Yii::error($e, $e->getMessage());
            $this->controller->stdout("Ошибка\n {$e->getMessage()}", Console::FG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }

}