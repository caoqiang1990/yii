<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Document */

$this->title = '';
$title = Yii::t('document', 'Create Document');
$this->params['breadcrumbs'][] = ['label' => Yii::t('document', 'Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $title;
?>
<div class="document-create">

  <?= $this->render('_form', [
	  'model' => $model,
      'cate' => $cate,
  ]) ?>

</div>
