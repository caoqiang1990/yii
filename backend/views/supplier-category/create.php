<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SupplierCategory */

$this->title = Yii::t('category', 'Create Supplier Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('category', 'Supplier Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-category-create">

    <?= $this->render('_form', [
        'model' => $model,
        'level' => $level,
        'status' => $status,
    ]) ?>

</div>
