<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Pitch */
/* @var $form yii\widgets\ActiveForm */
dmstr\web\AdminLteAsset::register($this);

?>

<div class="pitch-form">
    <table style="width:100%">
        <tr>
            <td colspan="3"><h1><?= Html::encode($this->title) ?></h1></td>
            <td><img src="<?= Url::to('@web/images/logo.jpg') ?>" style="width:110px;height:110px;align:right;"/></td>
        </tr>
    </table>

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12">
            <label class="text-left">项目名称</label>
        </div>
        <div class="col-xs-6">
            <p class="text-left"><?= $pitchModel->name ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <label class="text-left">准备材料</label>
            <p class="text-left"><?= $pitchModel->document; ?></p>
        </div>
    </div>
    <?= $form->field($model, 'attachment')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'pitch_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'sid')->hiddenInput()->label(false) ?>
    <?php
    echo $form->field($model, 'attachment_id')->widget(FileInput::className(), [
        'options' => [
            'multiple' => true,
            //'accept' => 'image/*'
        ],
        'pluginOptions' => [
            // 异步上传的接口地址设置
            'uploadUrl' => \yii\helpers\Url::to(['upload-attachment']),
            'uploadExtraData' => [
                'field' => 'attachment_id',
            ],
            'uploadAsync' => true,
            //'initialPreview'=> $model->attachment_url ? $model->attachment_url : "",
            'initialPreviewAsData' => true,
            'initialCaption' => "$model->attachment_id",
            'initialPreview' => $initialPreview,
            'initialPreviewConfig' => $initialPreviewConfig,
            'deleteUrl' => \yii\helpers\Url::to(['delete-attachment']),
        ],
        //网上很多地方都没详细说明回调触发事件，其实fileupload为上传成功后触发的，三个参数，主要是第二个，有formData，jqXHR以及response参数，上传成功后返回的ajax数据可以在response获取
        'pluginEvents' => [
            'fileuploaded' => "function (object,data){
                    $('.field-pitchattachment-attachment').append('<input type=\'hidden\' name=\'PitchAttachment[attachment][]\' value='+data.response.imageid+'>');
                    alert('上传成功');
                }",
            //错误的冗余机制
            'error' => "function (){
                    alert('上传失败');
                }"
        ],

    ])->label('上传附件');
    ?>

    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
