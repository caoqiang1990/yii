<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SupplierLevelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('level', 'Supplier Levels');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-level-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if (Helper::checkRoute('create')) { ?>
            <?= Html::a(Yii::t('level', 'Create Supplier Level'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            //'options'=>['class'=>'hidden']//关闭分页
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
            'maxButtonCount' => 5,
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'level_name',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status ? '有效' : '无效';
                },
                'filter' => ['无效', '有效']
            ],
            'order_no',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('Y-m-d H:i:s', $model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return date('Y-m-d H:i:s', $model->updated_at);
                }
            ],
            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn('{view}{update}{delete}'),

            ],
        ],
    ]); ?>
</div>
