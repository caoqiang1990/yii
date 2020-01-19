<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '操作记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="handle-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
            //'options'=>['class'=>'hidden']//关闭分页
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
            'maxButtonCount' => 5,
        ],
        'columns' => [
            'title',
            [
                'attribute' => 'action',
                'value' => function ($model) {
                    $actions = ['create' => '新增', 'update' => '更新', 'delete' => '删除', 'login' => '登录', 'logout' => '退出'];
                    return isset($actions["$model->action"]) ? $actions["$model->action"] : '未知';
                }
            ],
            [
                'attribute' => 'addtime',
                'value' => function ($model) {
                    return date('Y-m-d H:i:s', $model->addtime);
                },
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}']
        ],
        'tableOptions' => ['class' => 'table table-striped']
    ]); ?>

</div>