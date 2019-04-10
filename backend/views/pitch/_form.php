<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;
use yii\web\View;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Pitch */
/* @var $form yii\widgets\ActiveForm */
$url = Url::to(['get-email']);
$formatJS = <<<JS
    $.each($(".email_flag input[name='Pitch[email_flag]']"),function(i){
        $(this).bind('click',function(){
            var email_flag = $(this).val();
            var sids = $('#pitch-sids').val();
            if (!sids) {
                alert('请选择相应的供应商！');
                return false;
            } 
            //选中时
            if (email_flag == 'y') {
                $.ajax({
                     type: "POST",
                     url: '{$url}',
                     data: {sids:sids},
                     dataType: "json",
                     success: function(data){
                                if (data.status == 'success') {
                                    $("input[name='Pitch[email_text]']").val(data.msg);
                                } 
                                if (data.status == 'fail') {
                                    alert('请选择相应的供应商！');
                                } 
                              }
                 });
            }
            //未选中时
            if (email_flag == 'n') {
                $("input[name='Pitch[email_text]']").val('');
            }
        });
    })

JS;


$this->registerJs($formatJS);
?>

<div class="pitch-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6">
            <?php
            echo $form->field($model, 'start_date')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => '比稿起始时间', 'value' => $start],
                'pluginOptions' => [
                    'autoclose' => true
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo $form->field($model, 'sids')->widget(Select2::classname(), [
                'data' => $suppliers,
                'size' => Select2::MEDIUM,
                'options' => ['placeholder' => '请选择要比稿的供应商', 'multiple' => true],
                'pluginOptions' => [
                    'tokenSeparators' => [',', ' '],
                    'maximumInputLength' => 10,
                    'allowClear' => true,
                ],
            ])->label('参与比稿供应商');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>
        </div>
    </div>


    <div class="row">

        <div class="col-xs-6">
            <?php
            $form->field($model, 'end_date')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => '比入稿结束时间'],
                'pluginOptions' => [
                    'autoclose' => true
                ]
            ]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'department')->label('发起部门')->textInput(['maxlength' => true, 'disabled' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo $form->field($model, 'auditor')->widget(Select2::classname(), [
                'data' => $users,
                'size' => Select2::MEDIUM,
                'options' => ['placeholder' => '请选择参与审核的人员', 'multiple' => true],
                'pluginOptions' => [
                    'tokenSeparators' => [',', ' '],
                    'maximumInputLength' => 10,
                    'allowClear' => true
                ],
            ])->label('参与比稿人员');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'document')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <?php //if($model->isNewRecord){$model->email_flag = 'y';}?>
        <div class="col-xs-6">
            <?php
            echo $form->field($model, 'email_flag')->radioList([
                'y' => '是',
                'n' => '否'
            ],['class' => 'email_flag']);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'email_text')->textInput(); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <a class="btn btn-primary" href="javascript:history.go(-1)">取消</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
