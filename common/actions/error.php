<?php

namespace common\actions;

use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\base\UserException;

class Error extends \yii\web\ErrorAction
{
    public $view;
    /**
     * @var string the name of the error when the exception name cannot be determined.
     * Defaults to "Error".
     */
    public $defaultName;
    /**
     * @var string the message to be displayed when the exception message contains sensitive information.
     * Defaults to "An internal server error occurred.".
     */
    public $defaultMessage;

    public function run()
    {
        $this->controller->layout = 'error';
        return parent::run();
    }
}

?>