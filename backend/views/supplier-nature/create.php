<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SupplierNature */

$this->title = Yii::t('nature', 'Create Supplier Nature');
$this->params['breadcrumbs'][] = ['label' => Yii::t('nature', 'Supplier Natures'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-nature-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'status' => $status,
    ]) ?>

</div>
