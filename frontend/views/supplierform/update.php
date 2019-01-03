<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */
$this->title = Yii::t('supplier', 'supplierbasic');
//$this->title = $title . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('suppliers', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('suppliers', 'Update');
?>
<div class="suppliers-update">

  <table style="width:100%;height:420px;background:url(./images/main1.jpg)"><tr><td colspan="3" style="padding-bottom: 200px;"><h1><?= Html::encode($this->title) ?></h1></td><td>&nbsp;</td></tr></table>

    <?= $this->render('_upform', [
        'model' => $model,
        'level' => $level,
        'firm_nature' => $firm_nature,
        'trade' => $trade,
        'type' => $type,
    ]) ?>

</div>
