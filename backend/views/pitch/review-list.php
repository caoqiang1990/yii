<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;
use yii\web\View;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PitchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = Yii::t('pitch', 'Pitches');
?>
<div class="pitch-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'desc',
            'start_date',
            'end_date',
            //'sids',
            //'record',
            //'remark',
            //'result:ntext',
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',

            // [
            //     'header' => '操作',
            //     'class' => 'yii\grid\ActionColumn',
            //     'template' => Helper::filterActionColumn('{view}{update}{delete}'), 

            // ],
            [
                //'label'=>  (Helper::checkRoute('supplier-detail/create') || Helper::checkRoute('history/index')) ? '更多操作' : '',
                'label' => (Helper::checkRoute('pitch/review')) ? '更多操作' : '',
                'format' => 'raw',
                'value' => function ($model) {
                    $operator_1 = '';
                    $operator_2 = '';
                    // if (Helper::checkRoute('supplier-detail/create')) {
                    //     $url_1 = Url::to(['supplier-detail/create','sid'=>$model->id]);
                    //     $operator_1 = Html::a('与我方关系', $url_1, ['title' => '与我方关系']);

                    // }

                    if (Helper::checkRoute('pitch/time-line')) {
                        $url_2 = Url::to(['pitch/time-line', 'id' => $model->id]);
                        $operator_2 = Html::a('查看', $url_2);
                    }
                    return $operator_1 . ' ' . $operator_2;
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
