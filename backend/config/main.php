<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'defaultRoute' => 'site',
    'modules' => [
	'admin' => [
			'class' => 'mdm\admin\Module',
//			'layout'=> 'left-menu'
		]
	],
	'aliases' => [
		'@mdm\admin' => '@vendor/mdmsoft/yii2-admin'
	],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // 使用数据库管理配置文件
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        // 'sentry' => [
        //     'class' => 'mito\sentry\Component',
        //     'dsn' => 'https://481a281e7ffa4d7cb875a877dbfa9ec7:d677c6fa5f484e79b579c29f01517d87@sentry.io/1372516', // private DSN 
        //     'publicDsn' => 'https://481a281e7ffa4d7cb875a877dbfa9ec7@sentry.io/1372516',
        //     'environment' => 'production', // if not set, the default is `production`
        //     'jsNotifier' => true, // to collect JS errors. Default value is `false`
        //     'jsOptions' => [ // raven-js config parameter
        //         'whitelistUrls' => [ // collect JS errors from these urls
        //             //'http://staging.my-product.com',
        //             //'https://my-product.com',
        //         ],
        //     ],
        // ],
        // 'log' => [
        //     'targets' => [
        //         [
        //             'class' => 'mito\sentry\Target',
        //             'levels' => ['error', 'warning'],
        //             'except' => [
        //                 'yii\web\HttpException:404',
        //             ],
        //         ],
        //     ],
        // ],            
        // 'on beforeRequest' => function($event) {
        //     \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_UPDATE, ['backend\components\AdminLog', 'write']);
        // },        
        // 'log' => [
        //     'traceLevel' => YII_DEBUG ? 3 : 0,
        //     'targets' => [
        //         [
        //             'class' => 'yii\log\FileTarget',
        //             'levels' => ['error', 'warning'],
        //         ],
        //     ],
        // ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.qq.com',
//                'username' => '351266168@qq.com',
//                'password' => 'nzffjrqglazicaii',
//                'port' => '465',
                'host' => 'smtp.qiye.163.com',
                'username' => 'aimer_gys@aimer.com.cn',
                'password' => 'tg5nA33etUk5nxbg', //tg5nA33etUk5nxbg   kA9wPkKy57YaQdYK
                'port' => '994',
                'encryption' => 'ssl',
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        //	'view' => [
        //		'theme' => [
        //			'pathMap' => [
        //				'@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
        //			]
        //		]
        //	]
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'vendor' => 'vendor.php', //可以加多个，是yii::t里面的第一个参数名
                        'suppliers' => 'suppliers.php',
                        'category' => 'suppliercategory.php',
                        'level' => 'supplierlevel.php',
                        'trade' => 'suppliertrade.php',
                        'type' => 'suppliertype.php',
                        'detail' => 'supplierdetail.php',
                        'funds' => 'supplierfunds.php',
                        'nature' => 'suppliernature.php',
                        'question' => 'question.php',
                    ],
                    //'basePath' => '@backend/message', //配置语言文件路径，现在采用默认的，就可以不配置这个
                ],
            ],
        ],

    ],
    'as access' =>[
	'class' => 'mdm\admin\components\AccessControl',
	'allowActions' => [
        'site/reset',
        'site/reset-password',
        'site/logout',
	]
    ],
    'params' => $params,
    'language' => 'zh-CN',
];
