<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use backend\widgets\HelloWidget;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-solid box-default">
<div class="box-header">
  <h3 class="box-title">基础信息</h3>
</div>
</div>
<div class="suppliers-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
    <div class="col-xs-6">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'level')->dropDownList($level) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'business_address')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'firm_nature')->dropDownList($firm_nature) ?>
    </div>    
    <div class="col-xs-6">
    <div class="form-group field-supplier-register_date required">
    <label class="control-label" for="supplier-register_date">注册时间</label>
    <?= DatePicker::widget([
    'model' => $model,
    'attribute' => 'register_date',
    'template' => '{addon}{input}',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);?>
    <div class="help-block"></div>
    </div>
    </div>

    <div class="col-xs-6">
    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-12">
    <?= $form->field($model, 'business_scope')->textArea(['rows'=>6]) ?>
    </div>    
    <div class="col-xs-12">
    <?= $form->field($model, 'coop_content')->textArea(['rows'=>6]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'register_fund')->textInput(['maxlength' => true,'placeholder' => '万元']) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'headcount')->textInput(['maxlength' => true]) ?>
    </div> 
    <div class="col-xs-6">
    <?= $form->field($model, 'trade')->dropDownList($trade) ?>
    </div>    
    <div class="col-xs-6">
    <?= $form->field($model, 'business_contact')->textInput(['maxlength' => true]) ?>
    </div>    
    <div class="col-xs-6">
    <?= $form->field($model, 'business_position')->textInput(['maxlength' => true]) ?>
    </div>        
    <div class="col-xs-6">
    <?= $form->field($model, 'business_phone')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'business_mobile')->textInput(['maxlength' => true]) ?>
    </div>    
    <div class="col-xs-6">
    <?= $form->field($model, 'business_type')->dropDownList($type) ?>
    </div>     
    <div class="col-xs-12">
    <?= $form->field($model, 'factory_summary')->textArea(['rows'=>6]) ?>
    </div>      
    <div class="col-xs-6">
    <?= $form->field($model, 'factory_land_area')->textInput(['maxlength' => true]) ?>
    </div>      
    <div class="col-xs-6">
    <?= $form->field($model, 'factory_work_area')->textInput(['maxlength' => true]) ?>
    </div>    
    <div class="col-xs-12">
    <?= $form->field($model, 'business_customer1')->textArea(['rows'=>6]) ?>
    </div>      
    <div class="col-xs-12">
    <?= $form->field($model, 'business_customer2')->textArea(['rows'=>6]) ?>
    </div>      
    <div class="col-xs-12">
    <?= $form->field($model, 'business_customer3')->textArea(['rows'=>6]) ?>
    </div>          
    <div class="col-xs-12">
    <?= $form->field($model, 'material1')->textArea(['rows'=>6]) ?>
    </div>      
    <div class="col-xs-12">
    <?= $form->field($model, 'material2')->textArea(['rows'=>6]) ?>
    </div>      
    <div class="col-xs-12">
    <?= $form->field($model, 'material3')->textArea(['rows'=>6]) ?>
    </div>           
    <div class="col-xs-12">
    <?= $form->field($model, 'instrument_device1')->textArea(['rows'=>6]) ?>
    </div>      
    <div class="col-xs-12">
    <?= $form->field($model, 'instrument_device2')->textArea(['rows'=>6]) ?>
    </div>      
    <div class="col-xs-12">
    <?= $form->field($model, 'instrument_device3')->textArea(['rows'=>6]) ?>
    </div>    
    <div class="col-xs-12">
    <?= $form->field($model, 'instrument_device4')->textArea(['rows'=>6]) ?>
    </div>                                
    <div class="form-group">
    <div class="col-xs-12">

        <?= Html::submitButton(Yii::t('suppliers', 'Save'), ['class' => 'btn btn-success']) ?>
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
