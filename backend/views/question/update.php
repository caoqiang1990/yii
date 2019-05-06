<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Question */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('question', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('question', 'Update');
?>
<div class="question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'suppliers' => $suppliers,
        'start' => $start,
    ]) ?>

</div>
