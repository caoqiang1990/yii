<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierCategory */
$title = Yii::t('category', 'Update Supplier Category: ');
$this->title = $title . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('category', 'Supplier Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('category', 'Update');
?>
<div class="supplier-category-update">

    <?= $this->render('_form', [
        'model' => $model,
        'level' => $level,
        'status' => $status,
    ]) ?>

</div>
