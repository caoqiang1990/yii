<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SupplierType */

$this->title = '新增供应商业务类型';
$this->params['breadcrumbs'][] = ['label' => '供应商业务类型', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-type-create">

    <?= $this->render('_form', [
        'model' => $model,
        'status' => $status,
    ]) ?>

</div>
