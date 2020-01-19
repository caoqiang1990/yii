<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Template;
use backend\models\Supplier;
use backend\models\TemplateRecord;
use backend\models\Question;
use mdm\admin\components\Helper;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\TemplateRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = Yii::t('template', 'Template Records');
?>
<div class="template-record-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'sid',
                'value' => function ($model) {
                    return Supplier::findOne($model->sid) ? Supplier::findOne($model->sid)->name : "";
                },
                'filter' => TemplateRecord::getSuppliers(),
            ],
            [
                'attribute' => 'template_id',
                'value' => function ($model) {
                    return Template::findOne($model->template_id) ? Template::findOne($model->template_id)->name : '';
                },
                'filter' => Template::getTemplates(),
            ],
//            [
//                'attribute' => 'question_id',
//                'value' => function ($model) {
//                    return Question::findOne($model->question_id)->title;
//                },
//                'filter' => Question::getQuestion(),
//            ],
            'department',
            'operator',
            'total',
            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn('{view}'),
            ],
        ],
    ]); ?>
</div>
