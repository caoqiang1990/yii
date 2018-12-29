<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Department */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="department-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'department_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pid')->dropDownList($level) ?>
    <?= $form->field($model, 'status')->dropDownList($status) ?>
    <?= $form->field($model, 'order_no')->input('number') ?>
    <?= $form->field($model, 'level')->hiddenInput(['value'=>$model->level])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('department', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
