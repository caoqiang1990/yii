<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
//此处点击按钮提交数据的jquery
function save_detail(){
    var name = $('#adminadd-name').val();   
    var enterprise_code = $('#adminadd-enterprise_code').val();
    var check_id = $('#adminadd-check').val();
    
    if (!name) {
        $('.field-adminadd-name').addClass('has-error');
        $('.field-adminadd-name .help-block').text('供应商全称不能为空!');
        return false;
    } else {
        $('.field-adminadd-name').removeClass('has-error');
        $('.field-adminadd-name .help-block').text('');
    }
    if (!enterprise_code) {
        $('.field-adminadd-enterprise_code').addClass('has-error');
        $('.field-adminadd-enterprise_code .help-block').text('营业执照不能为空!');
        return false;
    } else {
        $('.field-adminadd-enterprise_code').removeClass('has-error');
        $('.field-adminadd-enterprise_code .help-block').text('');        
    }
    var reg = /^[A-Za-z0-9]{18}/;
    if (!reg.test(enterprise_code)) {
        $('.field-adminadd-enterprise_code').addClass('has-error');
        $('.field-adminadd-enterprise_code .help-block').text('营业执照为18位数字或字母组成！');
        return false;
    } else {
        $('.field-adminadd-enterprise_code').removeClass('has-error');
        $('.field-adminadd-enterprise_code .help-block').text('');        
    }
    if (!check_id) {
        $('.field-adminadd-check_id').addClass('has-error');
        $('.field-adminadd-check_id .help-block').text('备案查询结果不能为空!');
        return false;
    } else {
        $('.field-adminadd-check_id').removeClass('has-error');
        $('.field-adminadd-check_id .help-block').text('');
    }
    $.ajax({
            url: "admin-save",
            type: "POST",
            dataType: "json",
            data: $('form').serialize(),
            success: function(data) {
                if (data.code == 'name') {
                    alert(data.message);
                }
                if (data.code == 'code') {
                    alert(data.message);
                }    
                if(data.code == 'exist') {
                    alert('此供应商已经存在，等级为'+data.type);
                    //location.href = '/supplier/admin-index';
                } 
                if (data.code == 'new') {
                    $('#update-prompt').text('您可以继续完善供应商信息，也可以将此链接发给供应商协助填写。');
                    $('#update-supplier').attr('href',data.url);
                    $('#update-text').text(data.url);
                }                    
                if (data.code == 'fail') {
                    alert('保存失败')
                }
            },
            error: function() {
                alert('网络错误！');
            }
        });
        return false;
}
JS;
$this->registerJs($js);

?>
<div class="suppliers-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-id',
        'action' => '',
        'enableAjaxValidation' => true,
        //'validationUrl' => Url::to(['supplier/admin-add']),     //数据异步校验
    ]); ?>
    <div class="row">
        <div class="col-xs-12">
            <blockquote>
                新增供应商
            </blockquote>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'name')->label('供应商全称')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'enterprise_code')->label('营业执照统一社会信用代码（18位）')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12">
            <p><b>天眼查：</b><a href="https://www.tianyancha.com" target="_blank">https://www.tianyancha.com</a></p>
            <p><b>企查查：</b><a href="https://www.qichacha.com" target="_blank">https://www.qichacha.com</a></p>
            <p>新增供应商请通过以上链接进行企业信息查询，并上传查询成功的界面截图（必填）</p>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'check')->hiddenInput()->label(false) ?>
            <?php
            echo $form->field($model, 'check_id')->widget(FileInput::className(), [
                'options' => [
                    'accept' => '*'
                ],
                'pluginOptions' => [
                    // 异步上传的接口地址设置
                    'uploadUrl' => \yii\helpers\Url::to(['admin-add/upload-attachment']),
                    'uploadExtraData' => [
                        'field' => 'check_id',
                    ],
                    'uploadAsync' => true,
                    'initialPreview' => $model->check_url ? $model->check_url : "",
                    'initialPreviewAsData' => true,
                    'initialCaption' => "$model->check_id",
                ],
                //网上很多地方都没详细说明回调触发事件，其实fileupload为上传成功后触发的，三个参数，主要是第二个，有formData，jqXHR以及response参数，上传成功后返回的ajax数据可以在response获取
                'pluginEvents' => [
                    'fileuploaded' => "function (object,data){
                        $('#adminadd-check').remove();
                        $('.field-adminadd-check').append('<input type=\'hidden\' id=\'adminadd-check\' name=\'AdminAdd[check]\' value='+data.response.imageid+'>');
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
            <a id="update-supplier" href=""><p id="update-prompt"></p></a>
            <p id="update-text"></p>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <a onclick="save_detail()" class="btn btn-success">确认</a>
                <a href="#" class="btn btn-primary" data-dismiss="modal">取消</a>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>