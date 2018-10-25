<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="suppliers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'level')->dropDownList($level) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'register_date')->textInput(['maxlength' => true,'id'=>'datepicker']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('suppliers', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?= Html::jsFile('@web/plugin/timepicker/bootstrap-datepicker.js') ?>
<script>
$(function () {
  //Date picker
  $('#datepicker').datepicker({
    autoclose: true,
    format:'yyyy-mm-dd'
  })

})

</script>
