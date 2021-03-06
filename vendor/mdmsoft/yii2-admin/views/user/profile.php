<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\Signup */

$this->title = '修改用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?php
                    echo $form->field($model,'head_url')->label('头像')->widget(FileInput::className(),[
                        'name' => 'attachment_53',
                        'pluginOptions' => [
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' =>  '选择头像',
                            'initialPreview'=> $model->head_url ? $model->head_url : "",
                            'initialPreviewAsData' => true,
                            'maxFileSize' => 2800
                        ],
                        'options' => ['accept' => 'image/*']
                    ]);
                ?>            
                <?= $form->field($model, 'truename')->label(\Yii::t('rbac-admin','truename'))->textInput(['readonly'=>true]) ?>

                <?= $form->field($model, 'email')->label(\Yii::t('rbac-admin','Email')) ?>
                <div class="form-group">
                    <?= Html::submitButton('更新', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>