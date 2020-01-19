<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use mdm\admin\components\Helper;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '';
$title = Yii::t('question', 'Questions');
$this->params['breadcrumbs'][] = $title;

$js = <<<JS
//此处点击按钮提交数据的jquery
$('.start').click(function(){
    var id = $(this).attr('data-id');
    $.ajax({
            url: "start",
            type: "post",
            dataType: "json",
            data: {'id':id},
            success: function(data) {
                if (data.status == 'success') {
                    alert(data.msg);
                    location.reload();
                }                    
                if (data.status == 'fail') {
                    alert(data.msg);
                    location.reload();
                }
            },
            error: function() {
                alert('网络错误！');
                location.reload();
            }
        });
})
$('.end').click(function(){
    var id = $(this).attr('data-id');
    $.ajax({
            url: "end",
            type: "post",
            dataType: "json",
            data: {'id':id},
            success: function(data) {
                if (data.status == 'success') {
                    alert(data.msg);
                    location.reload();
                }                    
                if (data.status == 'fail') {
                    alert(data.msg);
                    location.reload();
                }
            },
            error: function() {
                alert('网络错误！');
                location.reload();
            }
        });
})
$('.sync').click(function(){
    var id = $(this).attr('data-id');
    $.ajax({
            url: "sync",
            type: "get",
            dataType: "json",
            data: {'id':id},
            success: function(data) {
                if (data.status == 'success') {
                    alert(data.msg);
                    location.reload();
                }                    
                if (data.status == 'fail') {
                    alert(data.msg);
                    location.reload();

                }
            },
            error: function() {
                alert('网络错误！');
                location.reload();
            }
        });
})
JS;
$this->registerJs($js, View::POS_READY);

?>
<div class="question-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('question', 'Create Question'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
                'attribute' => 'desc',
                'format' => 'raw',
                'value' => function ($model) {
                    return "<div style=\"width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis\">" . $model->desc . "</div>";
                },
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    switch ($model->status) {
                        case 1 :
                            return '正常';
                            break;
                        case 2 :
                            return '开始';
                            break;
                        case 3 :
                            return '结束';
                            break;
                        default :
                            return null;
                    }
                }
            ],
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
                    $operator_3 = '';
                    $operator_4 = '';
                    $operator_5 = '';
                    if (Helper::checkRoute('question/start') && $model->status == 1) {
                        //$url_3 = Url::to(['question/sync','question_id'=>$model->id]);
                        $url_3 = 'javascript:void(0);';
                        $operator_3 = Html::a('评价开始', $url_3, ['title' => '评价开始', 'class' => 'start', 'data-id' => $model->id]);
                    }
                    if (Helper::checkRoute('question/end') && $model->status == 2) {
                        //$url_3 = Url::to(['question/sync','question_id'=>$model->id]);
                        $url_3 = 'javascript:void(0);';
                        $operator_4 = Html::a('评价结束', $url_3, ['title' => '评价结束', 'class' => 'end', 'data-id' => $model->id]);
                    }
                    if (Helper::checkRoute('question/sync') && $model->status == 3) {
                        //$url_3 = Url::to(['question/sync','question_id'=>$model->id]);
                        $url_3 = 'javascript:void(0);';
                        //$operator_5 = Html::a('同步', $url_3, ['title' => '同步', 'class' => 'sync', 'data-id' => $model->id]);
                        $operator_5 = '';
                    }
                    return $operator_1 . ' ' . $operator_2 . ' ' . $operator_3 . ' ' . $operator_4 . ' ' . $operator_5;
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
