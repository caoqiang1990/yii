<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierTrade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="supplier-trade-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'trade_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model,'status')->dropDownList([0=>'无效',1=>'有效'])?>
    <?= $form->field($model, 'order_no')->input('number') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
