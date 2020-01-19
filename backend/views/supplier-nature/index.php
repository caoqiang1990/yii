<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SupplierNatureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('nature', 'Supplier Natures');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-nature-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if (Helper::checkRoute('create')) { ?>
            <?= Html::a(Yii::t('nature', 'Create Supplier Nature'), ['create'], ['class' => 'btn btn-success']) ?>
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

            'nature_name',
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
            //'updated_at',

            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn('{view}{update}{delete}'),

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
