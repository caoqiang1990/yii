<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Answer */
$this->title = '';
$this->params['breadcrumbs'][] = ['label' => '问答列表', 'url' => ['question/index']];
?>
<div class="answer-create">

    <?= $this->render('_form', [
        'model' => $model,
        'question_id' => $question_id
    ]) ?>

</div>
