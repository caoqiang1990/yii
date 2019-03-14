<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Pitch */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('pitch', 'Pitches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('pitch', 'Update');
?>
<div class="pitch-update">

    <?= $this->render('_form', [
        'model' => $model,
        'suppliers' => $suppliers,
        'users' => $users,
    ]) ?>

</div>
