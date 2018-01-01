<?php
namespace backendApi\common\controllers;

use Yii;
use common\rest\FailData;
use backendApi\common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * Login action.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return Yii::$app->user->getIdentity();
        } else {
            return new FailData($model);
        }
    }
}