<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'timeZone'=>'Asia/Shanghai',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
                //日志配置
        'log' => [
            'targets' => [
                /*
                 *使用文件存储日志
                 */
                // 'file' => [
                //      //文件方式存储日志操作对应操作对象
                //     'class' => 'yii\log\FileTarget',
                //       定义存储日志信息的级别，只有在这个数组的数据才能会使用当前方式存储起来
                //       有trace（用于开发调试时记录日志，需要把YII_DEBUG设置为true），
                //         error（用于记录不可恢复的错误信息)，
                //         warning（用于记录一些警告信息)
                //         info(用于记录一些系统行为如管理员操作提示)
                //         这些常用的。
                    
                //     'levels' => ['info','error'],
                //     /**
                //      * 按类别分类
                //      * 默认为空，即所有。yii\* 指所有以 yii\ 开头的类别.
                //      */
                //     'categories' => ['yii\*'],
                // ],
                /*
                 *使用数据库存储日志
                 */
                'db' => [
                     //数据库存储日志对象
                    'class' => 'yii\log\DbTarget',
                     //同上
                    'levels' => ['error', 'warning'],
                ]
            ],
        ],
    ],
];
