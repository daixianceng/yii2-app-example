<?php
namespace api\common\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use common\models\Post;

/**
 * Post controller
 */
class PostController extends Controller
{
    /**
     * Index action
     */
    public function actionIndex()
    {
        $provider = new ActiveDataProvider([
            'query' => Post::find(),
            'sort' => [
                'defaultOrder' => [
                    Post::sortField() => SORT_ASC,
                ],
            ],
        ]);

        return $provider;
    }

    /**
     * View action
     */
    public function actionView($id)
    {
        $model = Post::findOne($id);

        if (!$model) {
            throw new BadRequestHttpException('Bad request');
        }

        return $model;
    }
}