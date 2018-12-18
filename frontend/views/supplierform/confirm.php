<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */

$this->title = \Yii::t('suppliers','submit_confirm');
$this->params['breadcrumbs'][] = ['label' => Yii::t('suppliers', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::tag('h2', '信息已成功提交！', ['class' => 'confirmtext']); ?>
    </p>

</div>
