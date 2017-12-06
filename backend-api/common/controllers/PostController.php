<?php
namespace backendApi\common\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\Post;
use backend\models\PostSearch;

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
        return (new PostSearch())->search(Yii::$app->request->queryParams);
    }

    /**
     * View action
     */
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}