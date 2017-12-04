<?php
namespace backendApi\common\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use common\models\User;

/**
 * User controller
 */
class UserController extends Controller
{
    /**
     * Index action
     */
    public function actionIndex()
    {
        $provider = new ActiveDataProvider([
            'query' => User::find(),
            'sort' => [
                'defaultOrder' => [
                    User::sortField() => SORT_ASC,
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
        $model = User::findOne($id);

        if (!$model) {
            throw new BadRequestHttpException('Bad request');
        }

        return $model;
    }
}