<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SuppliersBasic */

$this->title = Yii::t('supplier', 'supplierbasic');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('supplier', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div style="width:1280px;align:right;"><img src="./images/logo.jpg" style="width:250px;height:250px;align:right;" /></div>

    <?= $this->render('_form', [
        'model' => $model,
        'level' => $level,
        'firm_nature' => $firm_nature,
        'trade' => $trade,
        'type' => $type,
    ]) ?>
</div>
