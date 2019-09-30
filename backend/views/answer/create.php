<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Answer */
$this->title = '';
$this->params['breadcrumbs'][] = ['label' => '问答列表', 'url' => ['template/index']];
?>
<div class="answer-create">

    <?= $this->render('_form', [
        'model' => $model,
        'template_id' => $template_id
    ]) ?>

</div>
