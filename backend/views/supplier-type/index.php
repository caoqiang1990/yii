<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SupplierTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '合作业务类型';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-type-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增合作业务类型', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'type_name',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status ? '有效' : '无效';
                },
                'filter'=>['无效','有效'],
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    return date('Y-m-d H:i:s',$model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($model){
                    return date('Y-m-d H:i:s',$model->updated_at);
                }
            ], 

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
