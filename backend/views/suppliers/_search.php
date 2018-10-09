<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SuppliersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="suppliers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sname') ?>

    <?= $form->field($model, 'legal_person') ?>

    <?= $form->field($model, 'business_license') ?>

    <?= $form->field($model, 'tax_registration_certificate') ?>

    <?php // echo $form->field($model, 'orcc') ?>

    <?php // echo $form->field($model, 'service_authorization_letter') ?>

    <?php // echo $form->field($model, 'certified_assets') ?>

    <?php // echo $form->field($model, 'effective_credentials') ?>

    <?php // echo $form->field($model, 'opening_bank') ?>

    <?php // echo $form->field($model, 'bank_no') ?>

    <?php // echo $form->field($model, 'account_name') ?>

    <?php // echo $form->field($model, 'account_no') ?>

    <?php // echo $form->field($model, 'registration_certificate') ?>

    <?php // echo $form->field($model, 'manufacturing_licence') ?>

    <?php // echo $form->field($model, 'business_certificate') ?>

    <?php // echo $form->field($model, 'credibility_certificate') ?>

    <?php // echo $form->field($model, 'headcount') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'telephone') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'fax') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'contact') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'black_box') ?>

    <?php // echo $form->field($model, 'white_box') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'update_date') ?>

    <?php // echo $form->field($model, 'operator') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
