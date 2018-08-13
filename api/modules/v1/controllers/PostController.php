<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\Post;

class PostController extends \api\common\controllers\PostController
{
    /**
     * @inheritdoc
     */
    protected function findModel($id)
    {
        if (($model = Post::findByKey($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
