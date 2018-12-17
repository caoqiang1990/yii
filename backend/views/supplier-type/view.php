<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierType */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('type','Supplier Types'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-type-view">

    <p>
        <?= Html::a(Yii::t('type','Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('type','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type_name',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status ? '有效' : '无效';
                }
            ],
            [
                'attribute' => 'created_at',
                'value' =>function($model){
                    return date('Y-m-d H:i:s',$model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($model){
                    return date('Y-m-d H:i:s',$model->updated_at);
                }
            ]
        ],
    ]) ?>

</div>
