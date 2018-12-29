<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Department */

$this->title = Yii::t('department', 'Create Department');
$this->params['breadcrumbs'][] = ['label' => Yii::t('department', 'Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-create">

    <?= $this->render('_form', [
        'model' => $model,
        'level' => $level,
        'status' => $status,
    ]) ?>

</div>
