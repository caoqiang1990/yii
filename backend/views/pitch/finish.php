<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;
use kartik\file\FileInput;

$this->title = '';
?>
<div class="pitch-create">

    <div class="pitch-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'disabled' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <?= $form->field($model, 'desc')->textarea(['rows' => 6, 'disabled' => true]) ?>
            </div>
        </div>

        <?= $form->field($model, 'record')->hiddenInput()->label(false) ?>
        <?php
        echo $form->field($model, 'record_id')->widget(FileInput::className(), [
            'options' => [
                'multiple' => true,
                'accept' => 'image/*'
            ],
            'pluginOptions' => [
                // 异步上传的接口地址设置
                'uploadUrl' => \yii\helpers\Url::to(['upload-attachment']),
                'uploadExtraData' => [
                    'field' => 'record_id',
                ],
                'uploadAsync' => true,
                'initialPreview' => $model->record_url ? $model->record_url : "",
                'initialPreviewAsData' => true,
                'initialCaption' => "$model->record_id",
            ],
            //网上很多地方都没详细说明回调触发事件，其实fileupload为上传成功后触发的，三个参数，主要是第二个，有formData，jqXHR以及response参数，上传成功后返回的ajax数据可以在response获取
            'pluginEvents' => [
                'fileuploaded' => "function (object,data){
                    console.log(object);
                    console.log(data);
                    $('input[name=\'Pitch\[record\]\']').val(data.response.imageid);
                    alert('上传成功');
                }",
                //错误的冗余机制
                'error' => "function (){
                    alert('上传失败');
                }"
            ],

        ]);
        ?>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'result')->textInput() ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>
            </div>
        </div>


        <div class="form-group">
            <?= Html::submitButton('结束', ['class' => 'btn btn-success']) ?>
            <a class="btn btn-primary" href="javascript:history.go(-1)">取消</a>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
