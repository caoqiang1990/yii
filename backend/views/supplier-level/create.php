<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SupplierLevel */

$this->title = Yii::t('level', 'Create Supplier Level');
$this->params['breadcrumbs'][] = ['label' => Yii::t('level', 'Supplier Levels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-level-create">

    <?= $this->render('_form', [
        'model' => $model,
        'status' => $status,
    ]) ?>

</div>
