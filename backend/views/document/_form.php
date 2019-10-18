<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\models\Document */
/* @var $form yii\widgets\ActiveForm */


$js = <<<JS
//此处点击按钮提交数据的jquery
function save_detail(){
    var doc_id = $('#document-doc').val();
    
    if (!doc_id) {
        $('.field-document-doc_id').addClass('has-error');
        $('.field-document-doc_id .help-block').text('文档不能为空!');
        return false;
    } else {
        $('.field-document-doc_id').removeClass('has-error');
        $('.field-document-doc_id .help-block').text('');
    }
    $.ajax({
            url: "create",
            type: "POST",
            dataType: "json",
            data: $('form').serialize(),
            success: function(data) {
                if (data.code == 'success') {
                    location.href = '/document';
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
$this->registerJs($js, View::POS_HEAD);
?>

<div class="document-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'department')->hiddenInput(['value' => Yii::$app->user->identity->department])->label(false) ?>
    <div class="col-xs-6">
        <?= $form->field($model, 'doc_name') ?>
    </div>
    <div class="col-xs-6">
        <?= $form->field($model, 'cate')->dropDownList($cate) ?>
    </div>
    <div class="col-xs-12">
        <?php
        echo $form->field($model, 'doc_id')->widget(FileInput::className(), [
            'options' => [
                'accept' => '*'
            ],
            'pluginOptions' => [
                // 异步上传的接口地址设置
                'uploadUrl' => \yii\helpers\Url::to(['document/upload-attachment']),
                'uploadExtraData' => [
                    'field' => 'doc_id',
                ],
                'uploadAsync' => true,
                'initialPreview' => $model->doc_url ? $model->doc_url : "",
                'initialPreviewAsData' => true,
                'initialCaption' => "$model->doc_id",
            ],
            //网上很多地方都没详细说明回调触发事件，其实fileupload为上传成功后触发的，三个参数，主要是第二个，有formData，jqXHR以及response参数，上传成功后返回的ajax数据可以在response获取
            'pluginEvents' => [
                'fileuploaded' => "function (object,data){
                        $('#document-doc').remove();
                        $('.field-document-doc').append('<input type=\'hidden\' id=\'document-doc\' name=\'Document[doc]\' value='+data.response.imageid+'>');
                        alert('上传成功');
            }",
                //错误的冗余机制
                'error' => "function (){
                alert('上传失败');
            }"
            ],

        ]);
        ?>
        <?= $form->field($model, 'doc')->hiddenInput()->label(false) ?>
    </div>

    <div class="form-group">
        <div class="form-group">
            <div class="col-xs-12">
                <a onclick="save_detail()" class="btn btn-success">确认</a>
                <a href="#" class="btn btn-primary" data-dismiss="modal">取消</a>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
