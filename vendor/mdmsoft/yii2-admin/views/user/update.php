<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

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
                <?= $form->field($model, 'truename')->label(\Yii::t('rbac-admin','truename')) ?>
                <?= $form->field($model, 'department')->label(\Yii::t('rbac-admin','department'))->dropDownList($department,['prompt'=>'请选择部门']) ?>
                <?= $form->field($model, 'email')->label(\Yii::t('rbac-admin','Email')) ?>
                <div class="form-group">
                    <?= Html::submitButton('更新', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>