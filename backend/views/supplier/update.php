<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */
$title = Yii::t('suppliers', 'Update Suppliers: ');
$this->title = $title . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('suppliers', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('suppliers', 'Update');
?>
<div class="suppliers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'supplier_grade' => $supplier_grade,
        'firm_nature' => $firm_nature
    ]) ?>

</div>
