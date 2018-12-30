<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SupplierDetail */

$this->title = '合作关系';
$this->params['breadcrumbs'][] = ['label' => '供应商列表', 'url' => \yii\helpers\Url::to(['supplier/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-detail-create">
    <?= $this->render('_form', [
        'model' => $model,
        'name' => $name,
        'sid' => $sid,
        'detail_obj_list' => $detail_obj_list,
        'level' => $level,
        'second_level_department' => $second_level_department,
    ]) ?>

</div>
