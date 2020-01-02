<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;
use backend\models\Department;

/* @var $this yii\web\View */
/* @var $searchModel mdm\admin\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac-admin', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a(Yii::t('rbac-admin', 'Create User'), ['signup'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            [
                'attribute' => 'truename',
                'label' => '真实姓名'
            ],
            [
                'attribute' => 'department',
                'value' => function ($model) {
                    $department = Department::getDepartmentById($model->department);
                    return $department ? $department->department_name : '';
                }
            ],
            'email:email',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('Y-m-d H:i:s', $model->created_at);
                }
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status == 0 ? '无效用户' : '有效用户';
                },
                'filter' => [
                    0 => '无效用户',
                    10 => '有效用户'
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn(['view', 'activate', 'update', 'delete','admin-change-password']),
                'buttons' => [
                    'activate' => function ($url, $model) {
                        if ($model->status == 10) {
                            $options = [
                                'title' => Yii::t('rbac-admin', 'Activate'),
                                'aria-label' => Yii::t('rbac-admin', 'Activate'),
                                'data-confirm' => Yii::t('rbac-admin', '是否冻结该用户?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ];
                        } else {
                            $options = [
                                'title' => Yii::t('rbac-admin', 'Activate'),
                                'aria-label' => Yii::t('rbac-admin', 'Activate'),
                                'data-confirm' => Yii::t('rbac-admin', '是否取消冻结该用户?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ];
                        }
                        return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options);
                    },
                    'admin-change-password' => function ($url, $model) {
                        $is_administrator = Yii::$app->user->identity->is_administrator;
                        if ($is_administrator != 1) {
                            return '';
                        }
                        $options = [
                            'title' => Yii::t('rbac-admin', '修改密码'),
                            'aria-label' => Yii::t('rbac-admin', '修改密码'),
                            'data-confirm' => Yii::t('rbac-admin', '你要修改密码嘛？'),
//                            'data-method' => 'post',
//                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-cog"></span>', $url, $options);
                    }
                ]
            ],
        ],
    ]);
    ?>
</div>
