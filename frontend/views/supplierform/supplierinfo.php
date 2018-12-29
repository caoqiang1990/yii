<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;

$headers = Yii::$app->response->headers;

// 增加一个 Pragma 头，已存在的Pragma 头不会被覆盖。
$headers->add('Pragma', 'no-cache');

/* @var $this yii\web\View */
/* @var $model app\models\SuppliersBasic */

$this->title = Yii::t('supplier', 'supplierbasic');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('supplier', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-create">
  <table style="width:100%"><tr><td colspan="3"><h1><?= Html::encode($this->title) ?></h1></td><td><img src="./images/logo.jpg" style="width:110px;height:110px;align:right;" /></td></tr></table>
    <?= $this->render('_form', [
        'model' => $model,
        'level' => $level,
        'firm_nature' => $firm_nature,
        'trade' => $trade,
        'type' => $type,
    ]) ?>
</div>
