<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('template', 'Create Template'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'intro:ntext',
            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn('{view}{update}{delete}'),
            ],
            [
                //'label'=>  (Helper::checkRoute('supplier-detail/create') || Helper::checkRoute('history/index')) ? '更多操作' : '',
                'label' => (Helper::checkRoute('answer/index')) ? '更多操作' : '',
                'format' => 'raw',
                'value' => function ($model) {
                    $operator_1 = '';
                    $operator_2 = '';
                    if (Helper::checkRoute('template/preview')) {
                        $url_1 = Url::to(['template/preview', 'template_id' => $model->id]);
                        $operator_1 = Html::a('预览', $url_1, ['title' => '查看调查问卷']);

                    }

                    if (Helper::checkRoute('answer/create')) {
                        $url_2 = Url::to(['answer/create', 'template_id' => $model->id]);
                        $operator_2 = Html::a('添加选项', $url_2, ['title' => '添加选项']);
                    }

                    return $operator_1 . ' ' . $operator_2;
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
