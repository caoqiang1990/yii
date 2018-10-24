<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\SupplierLevel;
use backend\models\SupplierCategory;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */

$this->title = \Yii::t('suppliers','DetailView');
$this->params['breadcrumbs'][] = ['label' => Yii::t('suppliers', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            [
                'attribute' => 'supplier_grade',
                'value' => function($model){
                    return SupplierLevel::getLevelById($model->supplier_grade)->level_name;
                }
            ],
            [
                'attribute' => 'firm_nature',
                'value' => function($model){
                    return SupplierCategory::getCategoryById($model->firm_nature)->category_name;
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
        ],
    ]) ?>

</div>
