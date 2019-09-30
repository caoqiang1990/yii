<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Answer */
$this->title = '';
$this->params['breadcrumbs'][] = ['label' => '更新', 'url' => ['view', 'id' => $model->id]];
?>
<div class="answer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'template_id' => $template_id,
    ]) ?>

</div>
