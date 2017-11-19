<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use common\models\Category;
use common\models\Post;

class PostController extends \api\common\controllers\PostController
{
    /**
     * @inheritdoc
     */
    public function actionIndex($category = 'all')
    {
        $query = Post::find();
        if ($category !== 'all') {
            $categoryModel = Category::findByKey($category);
            if ($categoryModel) {
                $query->where(['category' => $categoryModel->id]);
            }
        }

        $provider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    Post::sortField() => SORT_ASC,
                ],
            ],
        ]);

        return $provider;
    }

    /**
     * @inheritdoc
     */
    public function actionView($id)
    {
        $model = Post::findByKey($id);

        if (!$model) {
            throw new BadRequestHttpException('Bad request');
        }

        return $model;
    }
}