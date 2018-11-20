<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use backend\widgets\HelloWidget;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('suppliers', 'Suppliers');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="suppliers-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'sid')->label(false)->hiddenInput(['value' => $sid]) ?>

    <div class="row">
    <div class="col-xs-6">
    <?= $form->field($model, 'one_level_department')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-xs-6">
    <?= $form->field($model, 'second_level_department')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'coop_fund1')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'trade_fund1')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'coop_fund2')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'trade_fund2')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'coop_fund3')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'trade_fund3')->textInput(['maxlength' => true]) ?>
    </div>                    
    <div class="col-xs-6">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
    </div>    
    <div class="col-xs-12">
    <?= $form->field($model, 'reason')->textArea(['rows'=>6]) ?>
    </div>    
    <div class="form-group">
    <div class="col-xs-12">

        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    </div>

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
