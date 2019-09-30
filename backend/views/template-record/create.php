<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TemplateRecord */

$this->title = Yii::t('template', 'Create Template Record');
$this->params['breadcrumbs'][] = ['label' => Yii::t('template', 'Template Records'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
