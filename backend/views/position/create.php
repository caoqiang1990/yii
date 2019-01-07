<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Position */

$this->title = Yii::t('position', 'Create Position');
$this->params['breadcrumbs'][] = ['label' => Yii::t('position', 'Positions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-create">

    <?= $this->render('_form', [
        'model' => $model,
        'status' => $status,
    ]) ?>

</div>
