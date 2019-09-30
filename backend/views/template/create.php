<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Template */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('template', 'Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('template', 'Create Template');
?>
<div class="template-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
