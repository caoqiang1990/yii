<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="suppliers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'legal_person')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'business_license')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tax_registration_certificate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'orcc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service_authorization_letter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'certified_assets')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'effective_credentials')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'opening_bank')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'account_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'account_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'registration_certificate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manufacturing_licence')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'business_certificate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'credibility_certificate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'headcount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'black_box')->textInput() ?>

    <?= $form->field($model, 'white_box')->textInput() ?>

    <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'operator')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('suppliers', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
