<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Json;

$this->title = Yii::t('vendor', 'Create Menu');
?>

<div class="menu-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'vendorname')->textInput(['maxlength' => 128]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'imageFile')->fileInput() ?>
        </div>
    </div>
    <div class="form-group">
        <?=
        Html::submitButton($model->isNewRecord ? Yii::t('vendor', 'Create') : Yii::t('rbac-admin', 'Update'), ['class' => $model->isNewRecord
            ? 'btn btn-success' : 'btn btn-primary'])
        ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
