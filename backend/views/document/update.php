<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Document */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('document', 'Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('document', 'Update');
?>
<div class="document-update">

    <?= $this->render('_update', [
        'model' => $model,
        'cate' => $cate,
    ]) ?>

</div>
