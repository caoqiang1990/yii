<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
	'admin' =>[
		'class' => 'mdm\admin\Module',
		'layout' => 'left-menu',
	],
	],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'authManager' => [
    //        'enablePrettyUrl' => true,
    //        'showScriptName' => false,
    //        'rules' => [
		'class' => 'yii\rbac\DbManager',
          // ],
        ],
		'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'supplier' => 'supplierbasic.php', //可以加多个，是yii::t里面的第一个参数名
						'suppliers' => 'supplierbasic.php',
                    ],
                    //'basePath' => '@backend/message', //配置语言文件路径，现在采用默认的，就可以不配置这个
                ],
            ],
        ],
    ],
	'as access' =>[
		'class' => 'mdm\admin\components\AccessControl',
		'allowActions' =>[
			'site/*',
		],
	],
    'params' => $params,
	'language' => 'zh-CN',
];
