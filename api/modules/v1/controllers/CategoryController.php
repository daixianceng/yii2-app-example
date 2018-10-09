<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\db\Expression;
use common\models\Category;

class CategoryController extends \api\common\controllers\CategoryController
{
    /**
     * Finds all categories with posts
     *
     * @return array
     */
    public function actionWithPosts()
    {
        return Category::find()
            ->alias('t0')
            ->select(['t0.*', 'posts' => new Expression('COUNT(t1.id)')])
            ->joinWith('availablePosts t1')
            ->groupBy(['t0.id'])
            ->createCommand()
            ->queryAll();
    }
}
