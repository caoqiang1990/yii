<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Question;
use backend\models\Template;

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
            [
                    'attribute' => "template_id",
                    'value' => function($model) {
                        $template = Template::getTemplateById($model->template_id);
                        return $template ? $template->name : '';
                    }
            ],
            [
                'attribute' => "question_id",
                'value' => function($model) {
                    $question = Question::getQuestionById($model->question_id);
                    return $question ? $question->title : '';
                }
            ],
            'department',
            'reason:ntext',
            'total',
            'operator',
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
