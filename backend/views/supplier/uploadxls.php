<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SuppliersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '供应商手动导入';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-index">

    <p>

        <?php $form = ActiveForm::begin()?>
            <?php
echo $form->field($model, 'excelFile', ['options' => ['class' => 'filepath']])->label(false)->widget(FileInput::classname(), [
    'options' => [
        'module' => 'Supplier',
        'multiple' => false,
    ],
    'pluginOptions' => [
        // 异步上传的接口地址设置
        'uploadUrl' => \yii\helpers\Url::to(['upload']),
        'uploadAsync' => true,
    ],
    //网上很多地方都没详细说明回调触发事件，其实fileupload为上传成功后触发的，三个参数，主要是第二个，有formData，jqXHR以及response参数，上传成功后返回的ajax数据可以在response获取
    'pluginEvents' => [
        'fileuploaded' => "function (object,data){
                            console.log(object);
                            console.log(data);
                            $('.filepath input').val(data.response.filepath);
                            alert('上传成功');
                        }",
        //错误的冗余机制
        'error' => "function (){
                            alert('上传失败');
                        }",
    ],

]);
?>
        <?php ActiveForm::end()?>
    </p>

</div>
