<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierCategory */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('category', 'Supplier Categories'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-category-view">

    <p>
        <?= Html::a(Yii::t('category', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('category', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_name',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status ? '有效' : '无效';
                }
            ],
            'order_no',
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
