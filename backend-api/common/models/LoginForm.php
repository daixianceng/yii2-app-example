<?php
namespace backendApi\common\models;

use Yii;

/**
 * Login form
 */
class LoginForm extends \common\models\LoginForm
{
    /**
     * @inheritdoc
     */
    public function login()
    {
        if ($this->validate()) {
            $this->getUser()->generateAccessToken();
            return $this->getUser()->save(false) && Yii::$app->user->loginByAccessToken($this->getUser()->accessToken);
        } else {
            return false;
        }
    }
}
