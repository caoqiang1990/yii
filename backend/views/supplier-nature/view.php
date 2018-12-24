<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierNature */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('nature', 'Supplier Natures'), 'url' => ['index']];
?>
<div class="supplier-nature-view">

    <p>
    <?php if(Helper::checkRoute('Update')) {  ?>
        <?= Html::a(Yii::t('nature', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php }  ?>
    <?php if(Helper::checkRoute('Delete')) {  ?>
        <?= Html::a(Yii::t('nature', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('nature', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    <?php }  ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nature_name',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status ? '有效' : '无效';
                },
                'filter' => ['无效','有效']
            ],
            'order_no',
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    return date('Y-m-d H:i:s',$model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($model){
                    return date('Y-m-d H:i:s',$model->created_at);
                }
            ],
        ],
    ]) ?>

</div>
