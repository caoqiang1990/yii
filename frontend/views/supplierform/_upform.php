<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */
/* @var $form yii\widgets\ActiveForm */
?>
<script><?php $this->beginBlock('js_end') ?> 

$(document).on('click','.add',function(){
    if($("#supplier-business_type").val()== 1){
      var info=0;
      if($('#supplier-factory_summary').val()== undefined || $('#supplier-factory_summary').val()== '')
        info = 1;
      if($('#supplier-material_name1').val()== undefined || $('#supplier-material_name1').val()== '')
        info = 1;
      if($('#supplier-material_name2').val()== undefined || $('#supplier-material_name2').val()== '')
        info = 1;
      if($('#supplier-material_name3').val()== undefined || $('#supplier-material_name3').val()== '')
        info = 1;
      if($('#supplier-instrument_device1').val()== undefined || $('#supplier-instrument_device1').val()== '')
        info = 1;
      if($('#supplier-instrument_device2').val()== undefined || $('#supplier-instrument_device2').val()== '')
        info = 1;
      if($('#supplier-instrument_device3').val()== undefined || $('#supplier-instrument_device3').val()== '')
        info = 1;
      if($('#supplier-instrument_device4').val()== undefined || $('#supplier-instrument_device4').val()== '')
        info = 1;
      if($('#supplier-factory_land_area').val()== undefined || $('#supplier-factory_land_area').val()== '')
        info = 1;
      if($('#supplier-factory_work_area').val()== undefined || $('#supplier-factory_work_area').val()== '')
        info = 1;
      if(info){
        alert("工厂信息，原材料和仪器信息！均为必填项！谢谢合作！");
        $("html,body").animate({scrollTop:$("#factory").offset().top},1000);
        return false;
      }
    }
    if($("#supplier-business_type").val()== 3){
      if($('#supplier-enterprise_certificate_desc').val()== undefined || $('#supplier-enterprise_certificate_desc').val()== ''){
        alert("贸易商（中间商）代理资质为必填项！谢谢合作！");
        $("html,body").animate({scrollTop:$("#enter_cert").offset().top},1000);
        return false;
      }
    }


   })

<?php $this->endBlock() ?>

</script>

<?php $this->registerJs($this->blocks['js_end'],\yii\web\View::POS_END); ?>
<div class="box box-solid box-default">
<div class="box-header">
  <!--h3 class="box-title">供应商基础信息录入</h3--><br/>
  
</div>
</div>
<div class="suppliers-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'id'=>'supplier_form']); ?>
    <div class="row">
    <div class="col-xs-6">
    <?= Html::tag('label', Html::encode($model->name), ['class' => 'suppliername']) ?><br/>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hiddenInput()->label('') ?>
    </div>
    <div class="col-xs-6">
    <?= Html::tag('label', Html::encode("营业执照统一社会信用代码（18位）："), ['class' => 'enterprisecode']) ?>
    <?= Html::tag('label', Html::encode($model->enterprise_code_desc), ['class' => 'enterprisecoddesc']) ?><br/>
    <?= $form->field($model, 'enterprise_code_desc')->textInput(['maxlength' => true])->hiddenInput()->label('') ?>
    </div> 
    <div class="col-xs-6">
    <?= $form->field($model, 'business_address')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'firm_nature')->dropDownList($firm_nature,['prompt'=>'请选择']) ?>
    </div>    
    <div class="col-xs-6">
    <div class="form-group field-supplier-register_date required">
    <label class="control-label" for="supplier-register_date">*注册时间<? =Yii::t('suppliers','register_date') ?></label>
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
    <!--div class="col-xs-12">
    <? //= $form->field($model, 'coop_content')->textArea(['rows'=>6]) ?>
    </div-->
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
    <!-- div class="col-xs-12">
    <? //= $form->field($model, 'social_responsibility')->textArea(['rows'=>6]) ?>
    </div-->     
    <div class="col-xs-6" >
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
    <?= $form->field($model, 'business_mobile')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'business_phone')->textInput(['maxlength' => true]) ?>
    </div>    
    <div class="col-xs-6">
    <?= $form->field($model, 'business_email')->textInput(['maxlength' => true]) ?>
    </div>    
    <div class="col-xs-6">
    <?= $form->field($model, 'business_type',['options'=>['id'=>'business_type']])->dropDownList($type) ?>
    </div>     
    <div class="col-xs-12">
      <a id="factory"></a>
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
                        'initialPreview'=> $model->enterprise_code_url ? $model->enterprise_code_url : "",
                        
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
    <?= $form->field($model, 'enterprise_license_desc')->textInput(['maxlength' => true]) ?>
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
                        'initialPreview'=> $model->enterprise_license_url ? $model->enterprise_license_url : "",
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
    <?= $form->field($model, 'enterprise_license_relate_desc')->textInput(['maxlength' => true]) ?>
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
                        'initialPreview'=> $model->enterprise_license_relate_url ? $model->enterprise_license_relate_url : "",
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
    <a id="enter_cert"></a>
    <?= $form->field($model, 'enterprise_certificate_desc')->textInput(['maxlength' => true]) ?>
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
                        'initialPreview'=> $model->enterprise_certificate_url ? $model->enterprise_certificate_url : "",
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
    <?= $form->field($model, 'enterprise_certificate_etc_desc')->textInput(['maxlength' => true]) ?>
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
                        'initialPreview'=> $model->enterprise_certificate_etc_url ? $model->enterprise_certificate_etc_url : "",
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
    <div class="col-xs-6">

        <?= Html::submitButton($model->isNewRecord ? '新增' : '提交', ['class' => 'btn btn-success add']) ?>
        </div>
        <!--div class="col-xs-6">

          <?= Html::submitButton('保存', ['class' => 'btn btn-success save']) ?>
          </div -->
    </div>
    <?php ActiveForm::end(); ?>
    </div>

</div>
<?= Html::jsFile('@web/plugin/timepicker/bootstrap-datepicker.js') ?>
