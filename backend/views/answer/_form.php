<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Department */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="department-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'weight')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'desc')->textarea(['rows' => 5]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'answers_1')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'options_1')->textarea(['rows' => 5]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'answers_2')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'options_2')->textarea(['rows' => 5]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'answers_3')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'options_3')->textarea(['rows' => 5]) ?>
        </div>
    </div>
    <?= $form->field($model, 'template_id')->hiddenInput(['value'=>$template_id])->label(false) ?>

    <div class="row">
        <div class="col-xs-6">
            <?= Html::submitButton($model->isNewRecord ? '继续,下一选项' : '更新', ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-primary']) ?>
            <?= Html::a($model->isNewRecord ? '预览' : '取消', $model->isNewRecord ? Url::to(['template/preview', 'template_id' => $template_id]) : 'javascript:history.go(-1)', $model->isNewRecord ? ['class' => 'btn btn-primary btn-success'] : ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
