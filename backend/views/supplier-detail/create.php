<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SupplierDetail */

$this->title = '与我方关系';
$this->params['breadcrumbs'][] = ['label' => Yii::t('detail','Supplier Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'name' => $name,
        'sid' => $sid,
        'detail_obj_list' => $detail_obj_list,
    ]) ?>

</div>
