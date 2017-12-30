<?php
namespace backendApi\common\controllers;

use Yii;
use yii\web\Response;
use common\rest\DataInterface;
use common\rest\SuccessData;

/**
 * Base controller
 */
class Controller extends \yii\rest\Controller
{
    /**
     * @inheritdoc
     */
    public $serializer = [
        'class' => 'common\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON
        ];
        $behaviors['corsFilter'] = [
            'class' => 'yii\filters\Cors',
            'cors' => [
                'Origin' => Yii::$app->params['allowedOrigins'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page', 'X-Pagination-Page-Count', 'X-Pagination-Per-Page', 'X-Pagination-Total-Count'],
            ],
        ];
        if (!empty(Yii::$app->params['allowedHosts'])) {
            $behaviors['hostControl'] = [
                'class' => 'yii\filters\HostControl',
                'allowedHosts' => Yii::$app->params['allowedHosts'],
            ];
        }
        unset($behaviors['rateLimiter']);
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        if (!$result instanceof DataInterface) {
            $result = new SuccessData($result);
        }

        return parent::afterAction($action, $result);
    }
}