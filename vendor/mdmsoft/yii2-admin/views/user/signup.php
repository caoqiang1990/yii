<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\Signup */

$this->title = Yii::t('rbac-admin', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <?= Html::errorSummary($model)?>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->label(\Yii::t('rbac-admin','Username')) ?>
                <?= $form->field($model, 'truename')->label(\Yii::t('rbac-admin','truename')) ?>
                <?= $form->field($model, 'department')->label(\Yii::t('rbac-admin','department')) ?>
                <?= $form->field($model, 'mobile')->label(\Yii::t('rbac-admin','mobile')) ?>
                <?= $form->field($model, 'email')->label(\Yii::t('rbac-admin','Email')) ?>
                <?= $form->field($model, 'password')->label(\Yii::t('rbac-admin','Password'))->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('rbac-admin', 'Create'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
