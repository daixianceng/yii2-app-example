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
                'GET,HEAD <module>/categories' => '<module>/category/index',
                'GET,HEAD <module>/posts' => '<module>/post/index',
                'GET,HEAD <module>/posts/<id>' => '<module>/post/view',
                'GET,HEAD <module>/users' => '<module>/user/index',
                'GET,HEAD <module>/users/<id>' => '<module>/user/view',
            ],
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => 'json',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null && !$response->isSuccessful) {
                    $response->data = [
                        'status' => 'error',
                        'data' => $response->data,
                    ];
                }
            },
        ]
    ],
    'params' => $params,
];
