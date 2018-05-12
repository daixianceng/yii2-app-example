<?php
namespace backendApi\common\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\rest\SuccessData;
use common\rest\FailData;
use backend\models\Calculator;

/**
 * Calculation controller
 */
class CalculationController extends Controller
{
    /**
     * Daily posts action
     *
     * @return array
     */
    public function actionDailyPosts()
    {
        return (new Calculator())->dailyPosts(Yii::$app->request->queryParams);
    }
}