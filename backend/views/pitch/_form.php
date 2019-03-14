<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $model backend\models\Pitch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pitch-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-xs-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
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
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 10
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
            echo $form->field($model, 'start_date')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => '开始时间'],
                'pluginOptions' => [
                    'autoclose' => true
                ]
            ]);
        ?>
        </div>
        <div class="col-xs-6">
        <?php
            echo $form->field($model, 'end_date')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => '结束时间'],
                'pluginOptions' => [
                    'autoclose' => true
                ]
            ]);
        ?>       
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
        <?= $form->field($model, 'department')->label('发起部门')->textInput(['maxlength' => true,'disabled'=>true]) ?>
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
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 10
                    ],
                ])->label('参与审核人员');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
        <?= $form->field($model, 'document')->textInput(['maxlength' => true]) ?>
        </div>
    </div>    


    <div class="form-group">
         <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <a class="btn btn-primary" href="javascript:history.go(-1)">取消</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
