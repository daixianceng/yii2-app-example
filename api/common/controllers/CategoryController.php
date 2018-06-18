<?php
namespace api\common\controllers;

use Yii;
use backend\models\CategorySearch;


/**
 * Category controller
 */
class CategoryController extends Controller
{
    /**
     * Lists all Category models.
     * @return yii\data\ActiveDataProvider
     */
    public function actionIndex()
    {
        return (new CategorySearch())->search(Yii::$app->request->queryParams);
    }
}
