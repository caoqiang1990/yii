<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Department */
$title = Yii::t('department','Update Departments');
$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('department', 'Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('department', 'Update');
?>
<div class="department-update">

    <?= $this->render('_form', [
        'model' => $model,
        'level' => $level,
        'status' => $status,
    ]) ?>

</div>
