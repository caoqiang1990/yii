<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierLevel */
$title =  Yii::t('level', 'Update Supplier Level: ');
$this->title = $title . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('level', 'Supplier Levels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('level', 'Update');
?>
<div class="supplier-level-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
