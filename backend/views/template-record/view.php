<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TemplateRecord */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => Yii::t('template', 'Template Records'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
?>
<div class="template-record-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'template_id',
            'question_id',
            'department',
            'reason:ntext',
            'total',
            'operator',
            'is_satisfy',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('Y-m-d H:i:s', $model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return date('Y-m-d H:i:s', $model->updated_at);
                }
            ],
        ],
    ]) ?>

</div>
