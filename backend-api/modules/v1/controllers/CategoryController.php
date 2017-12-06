<?php
namespace backendApi\modules\v1\controllers;

use Yii;
use common\models\Category;

class CategoryController extends \backendApi\common\controllers\CategoryController
{
    /**
     * Index action
     */
    public function actionIndex()
    {
        return [
            'status' => 'success',
            'data' => Category::find()->orderBy(Category::sortField())->all(),
        ];
    }
}