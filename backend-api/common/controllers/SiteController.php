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
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['optional'] = ['*'];
        return $behaviors;
    }

    /**
     * Login action.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return Yii::$app->user->getIdentity()->toArray([], ['accessToken']);
        } else {
            return new FailData($model);
        }
    }
}