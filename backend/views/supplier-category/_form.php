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

    <div class="form-group">
        <?= Html::submitButton(Yii::t('category', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
