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
            <?= $form->field($model, 'status')->dropDownList($status, ['prompt' => '请选择状态']) ?>
        </div>

        <div class="col-xs-12">
            <?= $form->field($model, 'public_flag')->label('共享范围（非保密供应商请选择集团共享）')->radioList([
                'y' => '集团共享',
                'n' => '部门共享'
            ]) ?>
        </div>
        <div class="form-group">
            <div class="col-xs-12">

                <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
                <a class="btn btn-primary" href="javascript:history.go(-1)">取消</a>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>