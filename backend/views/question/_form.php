<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model backend\models\Question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <div class="col-xs-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="col-xs-6">
        <?php echo $form->field($model, 'start_date')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => '开始时间'],
            'pluginOptions' => [
                'autoclose' => true
            ]
        ]); ?>
    </div>
    <div class="col-xs-12">
        <?php
        echo $form->field($model, 'player')->widget(Select2::classname(), [
            'data' => $users,
            'size' => Select2::MEDIUM,
            'options' => ['placeholder' => '请选择参与评价的人员', 'multiple' => true],
            'pluginOptions' => [
                'tokenSeparators' => [',', ' '],
                'maximumInputLength' => 10,
                'allowClear' => true
            ],
        ])->label('参与评价人员');
        ?>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-8">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <a class="btn btn-primary" href="javascript:history.go(-1)">取消</a>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
