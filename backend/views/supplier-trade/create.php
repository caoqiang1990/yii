<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SupplierTrade */

$this->title = Yii::t('trade','Create Supplier Trade');
$this->params['breadcrumbs'][] = ['label' => Yii::t('trade','Supplier Trades'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-trade-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
