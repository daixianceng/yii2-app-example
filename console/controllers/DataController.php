<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Category;
use common\models\Post;
use common\models\User;

/**
 * Data controller
 *
 * @author Cosmo <daixianceng@gmail.com>
 */
class DataController extends Controller
{
    /**
     * Reset
     *
     * @return string
     */
    public function actionReset()
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {

            Post::deleteAll('1=1');
            Category::deleteAll('1=1');
            User::deleteAll('1=1');

            $transaction->commit();

            echo "\nReset successful.";
            return static::EXIT_CODE_NORMAL;
        } catch (\Exception $e) {
            $transaction->rollBack();
            echo "\n" . $e->getMessage();
            return static::EXIT_CODE_ERROR;
        }
    }
}