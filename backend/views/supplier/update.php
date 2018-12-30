<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */
$this->title = '';
$this->params['breadcrumbs'][] = ['label' => '更新基本信息', 'url' => ['basic']];
$this->params['breadcrumbs'][] = Yii::t('suppliers', 'Update');
?>
<div class="suppliers-update">

    <?= $this->render('_form', [
        'model' => $model,
        'level' => $level,
        'firm_nature' => $firm_nature,
        'trade' => $trade,
        'type' => $type,
    ]) ?>

</div>
