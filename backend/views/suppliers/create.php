<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Suppliers */

$this->title = Yii::t('suppliers', 'Create Suppliers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('suppliers', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
