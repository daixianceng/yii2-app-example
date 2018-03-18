<?php
namespace common\helpers;

use Yii;

class Url extends \yii\helpers\Url
{
    public static function toAvatar($name)
    {
        $baseUrl = Yii::$app->params['imageBaseUrl'];

        return $baseUrl . '/backend/avatar/' . $name;
    }
}
