<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TemplateRecord */

$this->title = Yii::t('template', 'Update Template Record: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('template', 'Template Records'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('template', 'Update');
?>
<div class="template-record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
