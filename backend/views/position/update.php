<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Position */

$this->title = Yii::t('position', 'Update Position: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('position', 'Positions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('position', 'Update');
?>
<div class="position-update">

    <?= $this->render('_form', [
        'model' => $model,
        'status' => $status,
    ]) ?>

</div>
