<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierTrade */
$title = Yii::t('trade', 'Update Supplier Trade: ');
$this->title = $title . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('trade', 'Supplier Trades'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('trade', 'Update');
?>
<div class="supplier-trade-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
