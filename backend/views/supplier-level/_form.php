<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierLevel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="supplier-level-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'level_name')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('level', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
