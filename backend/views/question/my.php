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
$this->params['breadcrumbs'][] = '我参与的评论';


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
<div class="question-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'title',
            'desc:ntext',
            'start_date',
            'end_date',
//            [
//                'header' => '操作',
//                'class' => 'yii\grid\ActionColumn',
//                'template' => Helper::filterActionColumn('{view}{update}{delete}'),
//
//            ],
            [
                //'label'=>  (Helper::checkRoute('supplier-detail/create') || Helper::checkRoute('history/index')) ? '更多操作' : '',
                'label' => (Helper::checkRoute('question/survey')) ? '更多操作' : '',
                'format' => 'raw',
                'value' => function ($model) {
                    $operator_1 = '';
                    $operator_2 = '';
//                    if (Helper::checkRoute('pitch/start') && $model->status == 'wait') {
//                        $url_1 = 'javascript:void(0);';
//                        $operator_1 = Html::a('上传资料', $url_1, ['title' => '邮件通知供方提供资料', 'class' => 'start', 'data-id' => $model->id]);
//
//                    }

                    if (Helper::checkRoute('question/survey')) {
                        $url_2 = Url::to(['survey', 'question_id' => $model->id]);
                        $operator_2 = Html::a('评价', $url_2, ['title' => '评价', 'class' => '', 'data-id' => $model->id]);
                    }

                    return $operator_1 . ' ' . $operator_2;
                }

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
