<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */

$this->title = \Yii::t('suppliers','submit_confirm');
$this->params['breadcrumbs'][] = ['label' => Yii::t('suppliers', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-view">

    <table style="width:100%">
      <tr><td colspan="2" style="width:35%"></td><td><h1><?= Html::tag('h2', '信息已成功提交！', ['class' => 'confirmtext']); ?></td><td colspan="2"></td></tr>
      <tr><td colspan="2"></td><td></td><td colspan="2"></td></tr>
    </table>

</div>
