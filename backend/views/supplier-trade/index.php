<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SupplierTradeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '所属行业列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-trade-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增所属行业', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'trade_name',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status ? '有效' : '无效';
                }
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
