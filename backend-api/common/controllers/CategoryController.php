<?php
namespace backendApi\common\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\Category;
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

    /**
     * Displays a single Category model.
     * @param string $id
     * @return Category
     */
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    /**
     * Creates a new Category model.
     * @return Category
     */
    public function actionCreate()
    {
        $model = new Category();
        $model->load(Yii::$app->request->post());
        $model->save();

        return $model;
    }

    /**
     * Updates an existing Category model.
     * @param string $id
     * @return Category
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post());
        $model->save();

        return $model;
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}