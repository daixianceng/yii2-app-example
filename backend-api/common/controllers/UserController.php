<?php
namespace backendApi\common\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use common\models\User;
use common\rest\SuccessData;
use common\rest\FailData;
use common\exceptions\UploadException;
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
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->setScenario(User::SCENARIO_INSERT);
        $model->load(Yii::$app->request->post());

        if ($model->validate()) {
            $model->avatar = Yii::$app->params['user.defaultAvatar'];
            $model->setPassword($model->passwordNew);
            if ($model->save(false)) {
                Yii::$app->response->setStatusCode(201);
                return $model;
            } else {
                return new FailData([
                    'message' => 'Failed to save model',
                ]);
            }
        } else {
            return new FailData($model);
        }
    }

    /**
     * Updates an existing User model.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post());

        if ($model->validate()) {
            if (!empty($model->passwordNew)) {
                $model->setPassword($model->passwordNew);
            }
            if ($model->save(false)) {
                return $model;
            } else {
                return new FailData([
                    'message' => 'Failed to save model',
                ]);
            }
        } else {
            return new FailData($model);
        }
    }

    /**
     * Updates avatar of an existing User model.
     * @param string $id
     * @return mixed
     */
    public function actionUpdateAvatar($id)
    {
        $model = $this->findModel($id);
        $model->setScenario(User::SCENARIO_UPLOAD_AVATAR);
        $model->avatarFile = UploadedFile::getInstanceByName('file');

        if ($model->avatarFile && $model->avatarFile->getHasError()) {
            throw new UploadException($model->avatarFile->error);
        }

        if ($model->validate('avatarFile')) {

            $model->generateAvatarName($model->avatarFile->extension);
            $filename = Yii::getAlias(Yii::$app->params['user.avatarPath']) . DIRECTORY_SEPARATOR . $model->avatar;

            if (!$model->avatarFile->saveAs($filename)) {
                return new FailData([
                    'message' => 'Failed to save file to disk',
                ]);
            }
            if ($model->save(false)) {
                return $model;
            } else {
                return new FailData([
                    'message' => 'Failed to save model',
                ]);
            }
        } else {
            return new FailData($model);
        }
    }

    /**
     * Deletes an existing User model.
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