<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\file\FileInput;

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
    <?= $form->field($model, 'legal_person')->textInput(['maxlength' => true]) ?>
    </div>     
    <div class="col-xs-6">
    <?= $form->field($model, 'legal_position')->textInput(['maxlength' => true]) ?>
    </div>  
    <div class="col-xs-6">
    <?= $form->field($model, 'legal_phone')->textInput(['maxlength' => true]) ?>
    </div>         
    <div class="col-xs-6">
    <?= $form->field($model, 'sales_latest')->textInput(['maxlength' => true]) ?>
    </div>   
    <div class="col-xs-6">
    <?= $form->field($model, 'tax_latest')->textInput(['maxlength' => true]) ?>
    </div>               
    <div class="col-xs-12">
    <?= $form->field($model, 'social_responsibility')->textArea(['rows'=>6]) ?>
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
    <?= $form->field($model, 'business_email')->textInput(['maxlength' => true]) ?>
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
    <?= $form->field($model, 'material_name1')->textArea(['rows'=>6]) ?>
    </div>      
    <div class="col-xs-12">
    <?= $form->field($model, 'material_name2')->textArea(['rows'=>6]) ?>
    </div>      
    <div class="col-xs-12">
    <?= $form->field($model, 'material_name3')->textArea(['rows'=>6]) ?>
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
    <div class="col-xs-6">
    <?= $form->field($model, 'department_name')->textInput(['maxlength' => true]) ?>
    </div>      
    <div class="col-xs-6">
    <?= $form->field($model, 'department_manager')->textInput(['maxlength' => true]) ?>
    </div> 
    <div class="col-xs-6">
    <?= $form->field($model, 'department_manager_phone')->textInput(['maxlength' => true]) ?>
    </div>  
    <div class="col-xs-12">
    <?= $form->field($model,'enterprise_code')->hiddenInput()->label(false)?>
      <?php
                echo $form->field($model,'enterprise_code_image_id')->widget(FileInput::className(),[
                    'options' => [
                        'multiple' => false,
                        'accept' => 'image/*'
                    ],
                    'pluginOptions' => [
                        // 异步上传的接口地址设置
                        'uploadUrl' => \yii\helpers\Url::to(['upload-attachment']),
                        'uploadExtraData' => [
                            'field' => 'enterprise_code_image_id',
                        ],                        
                        'uploadAsync' => true,
                        'initialPreview'=>[
                            "$model->enterprise_code_url",
                        ],
                         'initialPreviewAsData'=>true,
                         'initialCaption'=>"$model->enterprise_code_image_id",
                    ],
                    //网上很多地方都没详细说明回调触发事件，其实fileupload为上传成功后触发的，三个参数，主要是第二个，有formData，jqXHR以及response参数，上传成功后返回的ajax数据可以在response获取
                    'pluginEvents' => [
                        'fileuploaded' => "function (object,data){
                            console.log(object);
                            console.log(data);
                            $('input[name=\'Supplier\[enterprise_code\]\']').val(data.response.imageid);
                            alert('上传成功');
                        }",
                        //错误的冗余机制
                        'error' => "function (){
                            alert('上传失败');
                        }"
                    ],

                    ]);
            ?>
    </div>         
    <div class="col-xs-12">
        <?= $form->field($model,'enterprise_license')->hiddenInput()->label(false)?>

      <?php
                echo $form->field($model,'enterprise_license_image_id')->widget(FileInput::className(),[
                    'options' => [
                        'multiple' => false,
                        'accept' => 'image/*'
                    ],
                    'pluginOptions' => [
                        // 异步上传的接口地址设置
                        'uploadUrl' => \yii\helpers\Url::to(['upload-attachment']),
                        'uploadExtraData' => [
                            'field' => 'enterprise_license_image_id',
                        ],
                        'uploadAsync' => true,
                        'initialPreview'=>[
                            "$model->enterprise_license_url",
                        ],
                         'initialPreviewAsData'=>true,
                         'initialCaption'=>"$model->enterprise_license_image_id",
                    ],
                    //网上很多地方都没详细说明回调触发事件，其实fileupload为上传成功后触发的，三个参数，主要是第二个，有formData，jqXHR以及response参数，上传成功后返回的ajax数据可以在response获取
                    'pluginEvents' => [
                        'fileuploaded' => "function (object,data){
                            console.log(object);
                            console.log(data);
                            $('input[name=\'Supplier\[enterprise_license\]\']').val(data.response.imageid);
                            alert('上传成功');
                        }",
                        //错误的冗余机制
                        'error' => "function (){
                            alert('上传失败');
                        }"
                    ],

                    ]);
            ?>
    </div>     
    <div class="col-xs-12">
        <?= $form->field($model,'enterprise_license_relate')->hiddenInput()->label(false)?>

      <?php
                echo $form->field($model,'enterprise_license_relate_image_id')->widget(FileInput::className(),[
                    'options' => [
                        'multiple' => false,
                        'accept' => 'image/*'
                    ],
                    'pluginOptions' => [
                        // 异步上传的接口地址设置
                        'uploadUrl' => \yii\helpers\Url::to(['upload-attachment']),
                        'uploadExtraData' => [
                            'field' => 'enterprise_license_relate_image_id',
                        ],
                        'uploadAsync' => true,
                        'initialPreview'=>[
                            "$model->enterprise_license_relate_url",
                        ],
                         'initialPreviewAsData'=>true,
                         'initialCaption'=>"$model->enterprise_license_relate_image_id",
                    ],
                    //网上很多地方都没详细说明回调触发事件，其实fileupload为上传成功后触发的，三个参数，主要是第二个，有formData，jqXHR以及response参数，上传成功后返回的ajax数据可以在response获取
                    'pluginEvents' => [
                        'fileuploaded' => "function (object,data){
                            console.log(object);
                            console.log(data);
                            $('input[name=\'Supplier\[enterprise_license_relate\]\']').val(data.response.imageid);
                            alert('上传成功');
                        }",
                        //错误的冗余机制
                        'error' => "function (){
                            alert('上传失败');
                        }"
                    ],

                    ]);
            ?>
    </div>         
    <div class="col-xs-12">
        <?= $form->field($model,'enterprise_certificate')->hiddenInput()->label(false)?>

      <?php
                echo $form->field($model,'enterprise_certificate_image_id')->widget(FileInput::className(),[
                    'options' => [
                        'multiple' => false,
                        'accept' => 'image/*'
                    ],
                    'pluginOptions' => [
                        // 异步上传的接口地址设置
                        'uploadUrl' => \yii\helpers\Url::to(['upload-attachment']),
                        'uploadExtraData' => [
                            'field' => 'enterprise_certificate_image_id',
                        ],
                        'uploadAsync' => true,
                        'initialPreview'=>[
                            "$model->enterprise_certificate_url",
                        ],
                         'initialPreviewAsData'=>true,
                         'initialCaption'=>"$model->enterprise_certificate_image_id",
                    ],
                    //网上很多地方都没详细说明回调触发事件，其实fileupload为上传成功后触发的，三个参数，主要是第二个，有formData，jqXHR以及response参数，上传成功后返回的ajax数据可以在response获取
                    'pluginEvents' => [
                        'fileuploaded' => "function (object,data){
                            console.log(object);
                            console.log(data);
                            $('input[name=\'Supplier\[enterprise_certificate\]\']').val(data.response.imageid);
                            alert('上传成功');
                        }",
                        //错误的冗余机制
                        'error' => "function (){
                            alert('上传失败');
                        }"
                    ],

                    ]);
            ?>
    </div>    
    <div class="col-xs-12">
        <?= $form->field($model,'enterprise_certificate_etc')->hiddenInput()->label(false)?>

      <?php
                echo $form->field($model,'enterprise_certificate_etc_image_id')->widget(FileInput::className(),[
                    'options' => [
                        'multiple' => false,
                        'accept' => 'image/*'
                    ],
                    'pluginOptions' => [
                        // 异步上传的接口地址设置
                        'uploadUrl' => \yii\helpers\Url::to(['upload-attachment']),
                        'uploadExtraData' => [
                            'field' => 'enterprise_certificate_etc_image_id',
                        ],
                        'uploadAsync' => true,
                        'initialPreview'=>[
                            "$model->enterprise_certificate_etc_url",
                        ],
                         'initialPreviewAsData'=>true,
                         'initialCaption'=>"$model->enterprise_certificate_etc_image_id",
                    ],
                    //网上很多地方都没详细说明回调触发事件，其实fileupload为上传成功后触发的，三个参数，主要是第二个，有formData，jqXHR以及response参数，上传成功后返回的ajax数据可以在response获取
                    'pluginEvents' => [
                        'fileuploaded' => "function (object,data){
                            console.log(object);
                            console.log(data);
                            $('input[name=\'Supplier\[enterprise_certificate_etc\]\']').val(data.response.imageid);
                            alert('上传成功');
                        }",
                        //错误的冗余机制
                        'error' => "function (){
                            alert('上传失败');
                        }"
                    ],

                    ]);
            ?>
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

  // var enterprise_code = "<?= $model->enterprise_code ?>";
  // if (enterprise_code) {
  //   $("input[name='Supplier[enterprise_code]']").val(enterprise_code);
  // }

})

</script>
