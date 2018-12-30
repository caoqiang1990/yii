<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierDetail */
$title = Yii::t('detail','Update Supplier Detail：');
$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('detail','Supplier Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('detail','Update');
?>
<div class="supplier-detail-update">

    <?= $this->render('_form', [
        'model' => $model,
        'name' => $name,
        'sid' => $sid,
        'detail_obj_list' => '',
        'level' => $level,
        'second_level_department' => $second_level_department,
    ]) ?>

</div>
