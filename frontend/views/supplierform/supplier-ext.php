<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="box box-solid box-default">
<div class="box-header">
  <h3 class="box-title">供应商字段信息添加</h3>
</div>
</div>
<div class="suppliers-form">
  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
  <div class="row">
    <div class="col-xs-6">
      <?= $form->field($model, 'sid')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
      <?= $form->field($model, 'field_name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
      <?= $form->field($model, 'field_label')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
      <?= $form->field($model, 'field_value')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
      <?= $form->field($model, 'field_type')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-12">
      <?= $form->field($model, 'field_text')->textArea(['rows'=>6]) ?>
    </div>  
      <div class="form-group">
    <div class="col-xs-12">

        <?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    </div>

</div>
