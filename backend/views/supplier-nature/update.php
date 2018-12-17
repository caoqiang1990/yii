<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierNature */
$title = Yii::t('nature','Update Supplier Nature: ');
$this->title = Yii::t('nature', $title . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('nature', 'Supplier Natures'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('nature', 'Update');
?>
<div class="supplier-nature-update">

    <?= $this->render('_form', [
        'model' => $model,
        'status' => $status,
    ]) ?>

</div>
