<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backendApi\common\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => 'backendApi\modules\v1\Module',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'logFile' => '@runtime/logs/app.' . date('Ymd') . '.log',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'POST <module>/login' => '<module>/site/login',

                'GET,HEAD <module>/categories' => '<module>/category/index',
                'GET,HEAD <module>/category/<id>' => '<module>/category/view',
                'POST <module>/category' => '<module>/category/create',
                'PUT,PATCH <module>/category/<id>' => '<module>/category/update',
                'DELETE <module>/category/<id>' => '<module>/category/delete',

                'GET,HEAD <module>/posts' => '<module>/post/index',
                'GET,HEAD <module>/post-tags' => '<module>/post/tags',
                'GET,HEAD <module>/post/<id>' => '<module>/post/view',
                'POST <module>/post' => '<module>/post/create',
                'PUT,PATCH <module>/post/<id>' => '<module>/post/update',
                'DELETE <module>/post/<id>' => '<module>/post/delete',

                'GET,HEAD <module>/users' => '<module>/user/index',
                'GET,HEAD <module>/user/<id>' => '<module>/user/view',
                'POST <module>/user' => '<module>/user/create',
                'PUT,PATCH <module>/user/<id>' => '<module>/user/update',
                'DELETE <module>/user/<id>' => '<module>/user/delete',
                'POST <module>/user/<id>/avatar' => '<module>/user/update-avatar',
            ],
        ],
        'errorHandler' => [
            'class' => 'common\rest\ErrorHandler',
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'format' => 'json',
        ],
    ],
    'params' => $params,
];
