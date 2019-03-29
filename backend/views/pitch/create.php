<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Pitch */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('pitch', 'Pitches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '创建比稿';
?>
<div class="pitch-create">

    <?= $this->render('_form', [
        'model' => $model,
        'suppliers' => $suppliers,
        'users' => $users,
        'start' => $start,
    ]) ?>

</div>
