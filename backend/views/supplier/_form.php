<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */
/* @var $form yii\widgets\ActiveForm */
$formatJS = <<<JS
    var dataCateID_1 = function(params){
        return {cate_id:'1'};
    };
    var dataCateID_2 = function(params){
        var cate_id1 = $('#supplier-cate_id1').val()
        //var cate_id = cate_id1.join('-');
        return {cate_id1:cate_id1};
    };
    var dataCateID_3 = function(params){
        var cate_id2 = $('#supplier-cate_id2').val()
        //var cate_id = cate_id2.join('-');
        return {cate_id2:cate_id2};
    };    
    var unSelect_1 = function(){
        $('#supplier-cate_id2').select2('val',0);
        $('#supplier-cate_id3').select2('val',0);
    }
    var unSelect_2 = function(){
        $('#supplier-cate_id3').select2('val',0);
    }    
JS;


$this->registerJs($formatJS, View::POS_HEAD);
$resultsJs = <<<JS
function (data,params) {
    return data;
}
JS;
?>
<div class="suppliers-form">

    <?php $form = ActiveForm::begin(); ?>
    <p>
        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <a class="btn btn-primary" href="javascript:history.go(-1)">取消</a>
    </p>
    <div class="row">
        <div class="col-xs-6">
          <?php //$form->field($model, 'business_type')->dropDownList($type)

          echo $form->field($model, 'cate_id1')->label('*供应商一级分类(如需添加请联系管理员)')->widget(Select2::classname(), [
              'options' => [
                  'placeholder' => '请选择总类',
                  'multiple' => false
              ],
              'pluginOptions' => [
                  'allowClear' => true,
                  'ajax' => [
                      'url' => Url::to(['get-all-cate']),
                      'dataType' => 'json',
                      'data' => new JsExpression('dataCateID_1'),
                      'processResults' => new JsExpression($resultsJs),
                    //'cache' => true,
                  ],
                  'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                  'templateResult' => new JsExpression('function(result) { return result.category_name; }'),
                  'templateSelection' => new JsExpression('function (select) { return select.category_name; }'),
              ],
              'pluginEvents' => [
                  "change" => "function() { console.log('change'); }",
                  "select2:opening" => "function() { console.log('select2:opening'); }",
                  "select2:open" => "function() { console.log('open'); }",
                  "select2:closing" => "function() { console.log('close'); }",
                  "select2:close" => "function() { console.log('close'); }",
                  "select2:selecting" => "function() { console.log('selecting'); }",
                  "select2:select" => "function() { console.log('select'); }",
                  "select2:unselecting" => "function() { console.log('unselecting'); }",
                  "select2:unselect" => new JsExpression('unSelect_1')
              ]

          ]);
          ?>
        </div>
        <div class="col-xs-6">
          <?php //$form->field($model, 'business_type')->dropDownList($type)
          echo $form->field($model, 'cate_id2')->label('*供应商二级分类(如需添加请联系管理员)')->widget(Select2::classname(), [
              'options' => [
                  'placeholder' => '请选择大类',
                  'multiple' => false
              ],
              'pluginOptions' => [
                  'allowClear' => true,
                  'ajax' => [
                      'url' => Url::to(['get-all-cate']),
                      'dataType' => 'json',
                      'data' => new JsExpression('dataCateID_2'),
                    //'data' =>  {'qid':$('#supplierdetail-cate_id1').val()},
                      'cache' => true,
                  ],
                  'escapeMarkup' => new JsExpression('function (markup) { console.log(markup);  return markup; }'),
                  'templateResult' => new JsExpression('function(result) { console.log(result); return result.category_name; }'),
                  'templateSelection' => new JsExpression('function (select) { console.log(select);  return select.category_name; }'),
              ],
              'pluginEvents' => [
                  "change" => "function() { console.log('change'); }",
                  "select2:opening" => "function() { console.log('select2:opening'); }",
                  "select2:open" => "function() { console.log('open'); }",
                  "select2:closing" => "function() { console.log('close'); }",
                  "select2:close" => "function() { console.log('close'); }",
                  "select2:selecting" => "function() { console.log('selecting'); }",
                  "select2:select" => "function() { console.log('select'); }",
                  "select2:unselecting" => "function() { console.log('unselecting'); }",
                  "select2:unselect" => new JsExpression('unSelect_2')
              ]

          ]);
          ?>
        </div>
        <div class="col-xs-6">
          <?php //$form->field($model, 'business_type')->dropDownList($type)
          echo $form->field($model, 'cate_id3')->label('*供应商三级分类(如需添加请联系管理员)')->widget(Select2::classname(), [
              'options' => [
                  'placeholder' => '请选择子类',
                  'multiple' => false
              ],
              'pluginOptions' => [
                  'allowClear' => true,
                  'ajax' => [
                      'url' => Url::to(['get-all-cate']),
                      'dataType' => 'json',
                      'data' => new JsExpression('dataCateID_3'),
                    //'data' =>  {'qid':$('#supplierdetail-cate_id1').val()},
                      'cache' => true,
                  ],
                  'escapeMarkup' => new JsExpression('function (markup) { console.log(markup);  return markup; }'),
                  'templateResult' => new JsExpression('function(result) { console.log(result); return result.category_name; }'),
                  'templateSelection' => new JsExpression('function (select) { console.log(select);  return select.category_name; }'),
              ],
              'pluginEvents' => [
                  "change" => "function() { console.log('change'); }",
              ]

          ]);
          ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('*供应商名录') ?>
        </div>

        <div class="col-xs-6">
            <?= $form->field($model, 'business_address')->textInput(['maxlength' => true])->label('*经营地址') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'firm_nature')->dropDownList($firm_nature)->label('*企业性质') ?>
        </div>
        <div class="col-xs-6">
            <div class="form-group field-supplier-register_date required">
                <label class="control-label" for="supplier-register_date">*注册时间</label>
                <?= DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'register_date',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]); ?>
            </div>
        </div>

        <div class="col-xs-6">
            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'business_scope')->textArea(['rows' => 6])->label('*经营范围（企业注册的经营范围）') ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'coop_content')->textArea(['rows' => 6]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'register_fund')->textInput(['maxlength' => true, 'placeholder' => '万元'])->label('*注册资金') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'legal_person')->textInput(['maxlength' => true])->label('*法人') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'legal_position')->textInput(['maxlength' => true])->label('*法人职务') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'legal_phone')->textInput(['maxlength' => true])->label('*法人电话') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'sales_latest')->textInput(['maxlength' => true])->label('*上一年度营业额') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'tax_latest')->textInput(['maxlength' => true])->label('*上一年度纳税额') ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'social_responsibility')->textArea(['rows' => 6]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'headcount')->textInput(['maxlength' => true])->label('*员工人数') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'trade')->dropDownList($trade)->label('*所属行业') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'business_contact')->textInput(['maxlength' => true])->label('*业务联系人') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'business_position')->textInput(['maxlength' => true])->label('*联系人职务') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'business_phone')->textInput(['maxlength' => true])->label('*联系人手机号') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'business_mobile')->textInput(['maxlength' => true])->label('*联系人电话') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'business_email')->textInput(['maxlength' => true])->label('*联系人邮箱') ?>
        </div>
        <div class="col-xs-6">
            <?= //$form->field($model, 'business_type')->dropDownList($type)
            $form->field($model, 'business_type')->widget(Select2::classname(), [
                'data' => $type,
                'options' => [
                    'placeholder' => '请选择业务类型',
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('*与爱慕已合作内容');
            ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'factory_summary')->textArea(['rows' => 6]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'factory_land_area')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'factory_work_area')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'business_customer1')->textArea(['rows' => 6]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'business_customer2')->textArea(['rows' => 6]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'business_customer3')->textArea(['rows' => 6]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'material_name1')->textArea(['rows' => 6]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'material_name2')->textArea(['rows' => 6]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'material_name3')->textArea(['rows' => 6]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'instrument_device1')->textArea(['rows' => 6]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'instrument_device2')->textArea(['rows' => 6]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'instrument_device3')->textArea(['rows' => 6]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'instrument_device4')->textArea(['rows' => 6]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'department_name')->textInput(['maxlength' => true])->label('*业务相关主要部门') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'department_manager')->textInput(['maxlength' => true])->label('*业务相关部门负责人') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'department_manager_phone')->textInput(['maxlength' => true])->label('*业务相关部门负责人电话') ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'enterprise_code')->hiddenInput()->label(false) ?>
            <?php
            echo $form->field($model, 'enterprise_code_image_id')->widget(FileInput::className(), [
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
                    'initialPreview' => $model->enterprise_code_url ? $model->enterprise_code_url : "",

                    'initialPreviewAsData' => true,
                    'initialCaption' => "$model->enterprise_code_image_id",
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
            <?= $form->field($model, 'enterprise_code_desc')->textInput() ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'enterprise_license')->hiddenInput()->label(false) ?>

            <?php
            echo $form->field($model, 'enterprise_license_image_id')->widget(FileInput::className(), [
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
                    'initialPreview' => $model->enterprise_license_url ? $model->enterprise_license_url : "",
                    'initialPreviewAsData' => true,
                    'initialCaption' => "$model->enterprise_license_image_id",
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
            <?= $form->field($model, 'enterprise_license_desc')->textInput() ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'enterprise_license_relate')->hiddenInput()->label(false) ?>

            <?php
            echo $form->field($model, 'enterprise_license_relate_image_id')->widget(FileInput::className(), [
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
                    'initialPreview' => $model->enterprise_license_relate_url ? $model->enterprise_license_relate_url : "",
                    'initialPreviewAsData' => true,
                    'initialCaption' => "$model->enterprise_license_relate_image_id",
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
            <?= $form->field($model, 'enterprise_license_relate_desc')->textInput() ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'enterprise_certificate')->hiddenInput()->label(false) ?>

            <?php
            echo $form->field($model, 'enterprise_certificate_image_id')->widget(FileInput::className(), [
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
                    'initialPreview' => $model->enterprise_certificate_url ? $model->enterprise_certificate_url : "",
                    'initialPreviewAsData' => true,
                    'initialCaption' => "$model->enterprise_certificate_image_id",
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
            <?= $form->field($model, 'enterprise_certificate_desc')->textInput() ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'enterprise_certificate_etc')->hiddenInput()->label(false) ?>

            <?php
            echo $form->field($model, 'enterprise_certificate_etc_image_id')->widget(FileInput::className(), [
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
                    'initialPreview' => $model->enterprise_certificate_etc_url ? $model->enterprise_certificate_etc_url : "",
                    'initialPreviewAsData' => true,
                    'initialCaption' => "$model->enterprise_certificate_etc_image_id",
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
        <div class="col-xs-12">
            <?= $form->field($model, 'enterprise_certificate_etc_desc')->textInput() ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'public_flag')->label('共享范围（非保密供应商请选择集团共享）')->radioList([
                'y' => '集团共享',
                'n' => '部门共享'
            ]) ?>
        </div>
        <div class="col-xs-6">
            <?php
            //$form->field($model, 'level')->label('*供应商等级')->dropDownList($level,['prompt'=>'请选择等级'])
            ?>
        </div>
        <?= $model->isNewRecord ? $form->field($model,'action')->hiddenInput(['value' => '12'])->label(false) : $form->field($model,'action')->hiddenInput(['value' => '12'])->label(false); ?>
        <?= $model->isNewRecord ? $form->field($model,'status')->hiddenInput(['value' => 'auditing'])->label(false) : $form->field($model,'status')->hiddenInput(['value' => 'auditing'])->label(false); ?>
        <div class="form-group">
            <div class="col-xs-12">

                <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <a class="btn btn-primary" href="javascript:history.go(-1)">取消</a>
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
            format: 'yyyy-mm-dd'
        })

        // var enterprise_code = "<?= $model->enterprise_code ?>";
        // if (enterprise_code) {
        //   $("input[name='Supplier[enterprise_code]']").val(enterprise_code);
        // }

    })

</script>
