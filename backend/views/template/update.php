<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Template */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('template', 'Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('template', 'Update');
?>
<div class="template-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
