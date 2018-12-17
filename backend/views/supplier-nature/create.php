<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SupplierNature */

$this->title = Yii::t('nature', 'Create Supplier Nature');
$this->params['breadcrumbs'][] = ['label' => Yii::t('nature', 'Supplier Natures'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-nature-create">

    <?= $this->render('_form', [
        'model' => $model,
        'status' => $status,
    ]) ?>

</div>
