<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="supplier-category-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pid')->dropDownList($level) ?>
    <?= $form->field($model, 'status')->dropDownList($status) ?>
    <?= $form->field($model, 'order_no')->input('number') ?>
    <?= $form->field($model, 'level')->hiddenInput(['value' => $model->level])->label(false); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
