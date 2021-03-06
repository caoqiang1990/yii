<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\web\View;
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $model backend\models\SupplierDetail */
/* @var $form yii\widgets\ActiveForm */

$formatJS = <<<JS
    var dataCateID_1 = function(params){
        return {cate_id:'1'};
    };
    var dataCateID_2 = function(params){
        var cate_id1 = $('#supplierdetail-cate_id1').val()
        var cate_id = cate_id1.join('-');
        return {cate_id1:cate_id};
    };
    var dataCateID_3 = function(params){
        var cate_id2 = $('#supplierdetail-cate_id2').val()
        var cate_id = cate_id2.join('-');
        return {cate_id2:cate_id};
    };    
    var unSelect_1 = function(){
        $('#supplierdetail-cate_id2').select2('val',0);
        $('#supplierdetail-cate_id3').select2('val',0);
    }
    var unSelect_2 = function(){
        $('#supplierdetail-cate_id3').select2('val',0);
    }    
JS;


$this->registerJs($formatJS, View::POS_HEAD);
$resultsJs = <<<JS
function (data,params) {
    return data;
}
JS;
?>

<div class="supplier-detail-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'sid')->label(false)->hiddenInput(['value' => $sid]) ?>

    <div class="row">
        <?php
        if ($model->isNewRecord) {
            ?>
            <div class="col-xs-6">
                <?php //$form->field($model, 'business_type')->dropDownList($type)

                echo $form->field($model, 'cate_id1')->label('*供应商一级分类(如需添加请联系管理员)')->widget(Select2::classname(), [
                    'options' => [
                        'placeholder' => '请选择总类',
                        'multiple' => true
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
            <?php
        }
        ?>
        <?php
        if ($model->isNewRecord) {
            ?>
            <div class="col-xs-6">
                <?php //$form->field($model, 'business_type')->dropDownList($type)
                echo $form->field($model, 'cate_id2')->label('*供应商二级分类(如需添加请联系管理员)')->widget(Select2::classname(), [
                    'options' => [
                        'placeholder' => '请选择大类',
                        'multiple' => true
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
            <?php
        }
        ?>
        <?php
        if ($model->isNewRecord) {
            ?>
            <div class="col-xs-6">
                <?php //$form->field($model, 'business_type')->dropDownList($type)
                echo $form->field($model, 'cate_id3')->label('*供应商三级分类(如需添加请联系管理员)')->widget(Select2::classname(), [
                    'options' => [
                        'placeholder' => '请选择子类',
                        'multiple' => true
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
            <?php
        }
        ?>
        <div class="col-xs-6">
            <?= $form->field($model, 'level')->label('*供应商等级（只针对当前合作关系）')->dropDownList($level, ['prompt' => '请选择等级']); ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'one_level_department')->label('*供应商管理部门(一级部门)')->textInput(['maxlength' => true, 'disabled' => true]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'second_level_department')->label('*供应商管理部门(二级部门)')->dropDownList($second_level_department, ['prompt' => '请选择二级部门', 'disabled' => true]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'develop_department')->label('*开发部门(供应商首次引入部门)')->textInput(['maxlength' => true, 'disabled' => true]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'one_coop_department')->label('*供应商合作部门(一级部门)')->dropDownList($one_level_department, ['prompt' => '请选择合作一级部门']) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'second_coop_department')->label('*供应商合作部门(二级部门)')->dropDownList($second_level_department, ['prompt' => '请选择合作二级部门']) ?>
        </div>
        <div class="col-xs-6">
            <div class="form-group field-supplier-coop_date required">
                <label class="control-label" for="supplier-coop_date">*合作起始时间(合同签订日期)</label>
                <?= DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'coop_date',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]); ?>
            </div>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'coop_fund1')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'trade_fund1')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'fund_year1')->hiddenInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'coop_fund2')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'trade_fund2')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'fund_year2')->hiddenInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'coop_fund3')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'trade_fund3')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'fund_year3')->hiddenInput(['maxlength' => true])->label(false) ?>

        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'name')->label('*我方对接人')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'mobile')->label('*我方对接人电话')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'reason')->label('*爱慕选择合作的原因')->textArea(['rows' => 6]) ?>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <?= $form->field($model, 'evaluate')->hiddenInput()->label(false) ?>
                <?php
                echo $form->field($model, 'evaluate_image_id')->widget(FileInput::className(), [
                    'options' => [
                        'multiple' => false,
                        'accept' => '*'
                    ],
                    'pluginOptions' => [
                        // 异步上传的接口地址设置
                        'uploadUrl' => \yii\helpers\Url::to(['upload-attachment']),
                        'uploadExtraData' => [
                            'field' => 'evaluate_image_id',
                        ],
                        'uploadAsync' => true,
                        'initialPreview' => $model->evaluate_url ? $model->evaluate_url : "",
                        'initialPreviewAsData' => true,
                        'initialCaption' => "$model->evaluate_image_id",
                    ],
                    //网上很多地方都没详细说明回调触发事件，其实fileupload为上传成功后触发的，三个参数，主要是第二个，有formData，jqXHR以及response参数，上传成功后返回的ajax数据可以在response获取
                    'pluginEvents' => [
                        'fileuploaded' => "function (object,data){
                        console.log(object);
                        console.log(data);
                        $('input[name=\'SupplierDetail\[evaluate\]\']').val(data.response.imageid);
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

                <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <a class="btn btn-primary" href="javascript:history.go(-1)">取消</a>
                <?php if ($detail_obj_list) { ?>
                    <?php //Html::a('追加一个与我方关系',Url::to(['supplier-detail/create','sid'=>$sid]))
                    ?>
                <?php } ?>
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
    })

</script>
