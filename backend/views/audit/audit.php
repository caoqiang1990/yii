<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */
/* @var $form yii\widgets\ActiveForm */
$this->title = '审核';
?>
<div class="suppliers-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">

    <div class="col-xs-6">
    <?= $form->field($model, 'status')->dropDownList($status) ?>
    </div>    
  
    <div class="col-xs-12">
        <?= $form->field($model,'public_flag')->radioList([
            'y' => '共享',
            'n' => '不共享'
        ]) ?>
    </div>                               
    <div class="form-group">
    <div class="col-xs-12">

        <?= Html::submitButton('提交', ['class' =>'btn btn-primary']) ?>
        <a class="btn btn-primary" href="javascript:history.go(-1)">取消</a>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    </div>

</div>