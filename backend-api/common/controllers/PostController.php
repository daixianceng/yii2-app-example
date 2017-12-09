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
     * @return Post
     */
    public function actionCreate()
    {
        $model = new Post();
        $model->authorId = Yii::$app->user->id;
        $model->load(Yii::$app->request->post());
        $model->save();

        return $model;
    }

    /**
     * Updates an existing Post model.
     * @param string $id
     * @return Post
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post());
        $model->save();

        return $model;
    }

    /**
     * Deletes an existing Post model.
     * @param string $id
     * @return array
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            return [
                'status' => 'success',
                'data' => [],
            ];
        } else {
            return [
                'status' => 'fail',
                'data' => [],
            ];
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