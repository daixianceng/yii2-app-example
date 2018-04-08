<?php
namespace backendApi\common\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\Post;
use common\rest\SuccessData;
use common\rest\FailData;
use backend\models\PostSearch;

/**
 * Post controller
 */
class PostController extends Controller
{
    /**
     * Lists all Post models.
     * @return yii\data\ActiveDataProvider
     */
    public function actionIndex()
    {
        return (new PostSearch())->search(Yii::$app->request->queryParams);
    }

    /**
     * Displays a single Post model.
     * @param string $id
     * @return Post
     */
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    /**
     * Creates a new Post model.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        $model->authorId = Yii::$app->user->id;
        $model->load(Yii::$app->request->post());

        if ($model->save()) {
            Yii::$app->response->setStatusCode(201);
            return $model;
        } else {
            return new FailData($model);
        }
    }

    /**
     * Updates an existing Post model.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post());

        if ($model->save()) {
            return $model;
        } else {
            return new FailData($model);
        }
    }

    /**
     * Deletes an existing Post model.
     * @param string $id
     * @return \common\rest\DataInterface
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            return new SuccessData();
        } else {
            return new FailData([
                'message' => 'Failed to delete model',
            ]);
        }
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