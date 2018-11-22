<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SuppliersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('suppliers', 'Suppliers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>

        <?php $form = ActiveForm::begin() ?>
            <?php
                echo $form->field($model, 'imageFile',['class'=>'filepath'])->widget(FileInput::classname(),[
                    'options' => [
                        'module' => 'Supplier',
                        'multipe' => false,
                    ],
                    'pluginOptions' => [
                        // 异步上传的接口地址设置
                        'uploadUrl' => \yii\helpers\Url::to(['uploadxls']),
                        'uploadAsync' => true,
                    ],
                    //网上很多地方都没详细说明回调触发事件，其实fileupload为上传成功后触发的，三个参数，主要是第二个，有formData，jqXHR以及response参数，上传成功后返回的ajax数据可以在response获取
                    'pluginEvents' => [
                        'fileuploaded' => function (object,data){ 
                            $(".filepath").val(data.filepath);
                            alert('上传成功');
                        },
                        //错误的冗余机制
                        'error' => function (){
                            alert('上传失败');
                        }
                    ]

                    ]);
            ?>
        <?= Html::submitButton('导入', ['class' => 'btn btn-success']) ?>
        <?php ActiveForm::end() ?>
    </p>

</div>
