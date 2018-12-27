<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
//此处点击按钮提交数据的jquery
$('.btn').click(function () {
var name = $('#adminadd-name').val();   
var enterprise_code = $('#adminadd-enterprise_code').val();

$.ajax({
        url: "admin-save",
        type: "POST",
        dataType: "json",
        data: $('form').serialize(),
        success: function(data) {
            if (data.code == 'name') {
                alert(data.message);
            }
            if (data.code == 'code') {
                alert(data.message);
            }    
            if(data.code == 'exist') {
                alert('此供应商已经存在，等级为'+data.type);
                location.href = '/supplier/admin-index';
            } 
            if (data.code == 'new') {
                $('#update-prompt').text('您可以继续完善供应商信息，也可以将此链接发给供应商协助填写。');
                $('#update-supplier').attr('href',data.url);
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
});

JS;
$this->registerJs($js);

?>
<div class="suppliers-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-id',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::to(['supplier/admin-add']),     //数据异步校验
    ]); ?>
    <div class="row">
    <div class="col-xs-6">
    <?= $form->field($model, 'name')->label('供应商全称')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-6">
    <?= $form->field($model, 'enterprise_code')->label('企业代码')->textInput(['maxlength' => true]) ?>
    </div> 
    <div class="col-xs-12">
        <a id="update-supplier" href=""><p id="update-prompt"></p></a>
    </div>   
    <div class="form-group">
    <div class="col-xs-12">

        <?= Html::submitButton('新增', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    </div>

</div>