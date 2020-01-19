<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '供应商管理系统';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

$css = <<<CSS
    .clear{
        clear:both;
    }
    .forget{
        position:relative;
    }
    .remember{
        padding-top: 5px;
    }
CSS;
$this->registerCss($css);
?>

<div class="login-box" style="width:100%;margin:auto;position: absolute;bottom:100px">
    <div class="login-logo">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body" style="width:900px;margin:auto">
        <!-- <p class="login-box-msg" style="font-size: 22px">供应商管理系统</p> -->

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false, 'options' => ['class' => 'form-inline']]); ?>
        <div class="col-sm-4">
            <?= $form
                ->field($model, 'username', $fieldOptions1)
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form
                ->field($model, 'password', $fieldOptions2)
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
        </div>
        <div class="col-xs-2">
            <?= $form->field($model, 'rememberMe', ['options' => ['class' => 'remember']])->checkbox() ?>
        </div>
        <!-- /.col -->
        <div class="col-xs-2">
            <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
        </div>

        <!-- /.col -->
        <?php ActiveForm::end(); ?>

        <div class="clear"></div>
    </div>

    <!-- /.login-box-body -->
</div><!-- /.login-box -->
