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


$js = <<<JS
//此处点击按钮提交数据的jquery
$('.finish').click(function(){
    var id = $(this).attr('data-id');
    $.ajax({
            url: "finish",
            type: "POST",
            dataType: "json",
            data: {'id':id},
            success: function(data) {
                if (data.status == 'success') {
                    alert(data.msg);
                    location.reload();
                }                    
                if (data.status == 'fail') {
                    alert(data.msg);
                }
            },
            error: function() {
                alert('网络错误！');
            }
        });
})

$('.start').click(function(){
    var id = $(this).attr('data-id');
    $.ajax({
            url: "start",
            type: "POST",
            dataType: "json",
            data: {'id':id},
            success: function(data) {
                if (data.status == 'success') {
                    alert(data.msg);
                    location.reload();
                }                    
                if (data.status == 'fail') {
                    alert(data.msg);
                }
            },
            error: function() {
                alert('网络错误！');
            }
        });
})
JS;
$this->registerJs($js, View::POS_READY);
?>
<div class="pitch-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('pitch', 'Create Pitch'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    $url = Url::to(['view', 'id' => $model->id]);
                    $options = ['title' => $model->name];
                    return Html::a($model->name, $url, $options);
                }
            ],
            [
                'attribute' => 'desc',
                'value' => function ($model) {
                    return truncate_utf8_string($model->desc, 30);
                }
            ],
            'start_date',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return getPitchStatusText($model->status);
                }
            ],
            //'end_date',
            //'sids',
            //'record',
            //'remark',
            //'result:ntext',
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',

//            [
//                'header' => '操作',
//                'class' => 'yii\grid\ActionColumn',
//                'template' => Helper::filterActionColumn('{view}{update}{delete}'),
//
//            ],
            [
                //'label'=>  (Helper::checkRoute('supplier-detail/create') || Helper::checkRoute('history/index')) ? '更多操作' : '',
                'label' => (Helper::checkRoute('pitch/start')) ? '更多操作' : '',
                'format' => 'raw',
                'value' => function ($model) {
                    $operator_1 = '';
                    $operator_2 = '';
//                    if (Helper::checkRoute('pitch/start') && $model->status == 'wait') {
//                        $url_1 = 'javascript:void(0);';
//                        $operator_1 = Html::a('比稿开始', $url_1, ['title' => '比稿开始', 'class' => 'start', 'data-id' => $model->id]);
//
//                    }

//                    if (Helper::checkRoute('pitch/finish') && $model->status != 10) {
//                        $url_2 = Url::to(['finish', 'id' => $model->id]);
//                        $operator_2 = Html::a('比稿结束', $url_2, ['title' => '比稿结束', 'class' => '', 'data-id' => $model->id]);
//                    }
                    if (Helper::checkRoute('pitch/record')) {
                        $url_2 = Url::to(['record', 'id' => $model->id]);
                        $operator_2 = Html::a('比稿记录', $url_2, ['title' => '比稿记录', 'class' => '', 'data-id' => $model->id]);
                    }
                    return $operator_1 . ' ' . $operator_2;
                }

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
