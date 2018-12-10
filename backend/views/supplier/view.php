<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\SupplierLevel;
use backend\models\SupplierCategory;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('suppliers', 'Suppliers'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-view">

    <p>
        <?= Html::a(Yii::t('suppliers', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('suppliers', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('suppliers', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            // [
            //     'attribute' => 'level',
            //     'value' => function($model){
            //         return SupplierLevel::getLevelById($model->level)->level_name;
            //     }
            // ],
            'url',
            'business_address',
            'register_date',
            'coop_content',
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
        ],
    ]) ?>

</div>
