<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Position */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="position-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'position_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList($status) ?>

    <?= $form->field($model, 'order_no')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('position', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
