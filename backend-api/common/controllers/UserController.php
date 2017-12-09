<?php
namespace backendApi\common\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\User;
use backend\models\UserSearch;

/**
 * User controller
 */
class UserController extends Controller
{
    /**
     * Lists all User models.
     * @return yii\data\ActiveDataProvider
     */
    public function actionIndex()
    {
        return (new UserSearch())->search(Yii::$app->request->queryParams);
    }

    /**
     * Displays a single User model.
     * @param string $id
     * @return User
     */
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    /**
     * Creates a new User model.
     * @return User
     */
    public function actionCreate()
    {
        $model = new User();
        $model->setScenario(User::SCENARIO_INSERT);
        $model->load(Yii::$app->request->post());
        $model->save();

        return $model;
    }

    /**
     * Updates an existing User model.
     * @param string $id
     * @return User
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post());
        $model->save();

        return $model;
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}