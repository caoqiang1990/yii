<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Question */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('question', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '新增评价';
?>
<div class="question-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'suppliers' => $suppliers,
        'templates' => $templates,
        'start' => $start,
        'end' => $end,
    ]) ?>

</div>
