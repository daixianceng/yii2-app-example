<?php
namespace api\common\controllers;

use Yii;
use common\models\Category;

/**
 * Category controller
 */
class CategoryController extends Controller
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